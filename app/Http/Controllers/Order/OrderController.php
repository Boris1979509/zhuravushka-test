<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Core;
use App\Http\Requests\Order\OrderRequest;
use App\Mail\OrderShipped;
use App\Models\Shop\Order;
use App\Services\Acquiring\Rshb;
use App\UseCases\Cart\CartService;
use App\UseCases\Order\OrderService;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class OrderController extends Core
{
    /**
     * @var array $data
     */
    protected $data = [];
    /**
     * @var OrderService $service
     */
    private $service;
    /**
     * @var Mailer $mailer
     */
    private $mailer;

    /**
     * OrderController constructor.
     * @param Mailer $mailer
     * @param OrderService $service
     */
    public function __construct(Mailer $mailer, OrderService $service)
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
        $this->service = $service;
        $this->mailer = $mailer;

    }

    /**
     * Order registration
     * @param CartService $cartService
     * @return Factory|View
     */
    public function place(CartService $cartService)
    {
        return view('order.place', $this->data, $cartService->getCart());
    }

    /**
     * @param OrderRequest $request
     * @param CartService $cartService
     * @param Rshb $bank
     * @return Factory|JsonResponse|View
     * @throws Throwable
     */
    public function confirm(OrderRequest $request, CartService $cartService, Rshb $bank)
    {
        $order = $cartService->getOrder(); // Текущий заказ
        $total_cost = $cartService->getTotalSum();
        // Если в запросе есть поле телефон и оно не пустое
        if ($request->has('phone') && is_null($request->input('phone'))) {
            return response()->json([
                'error' => view('flash.index')
                    ->with('error', __('The phone number was not confirmed'))
                    ->render(),
            ]);
        }
        if ($request->get('payment_type') === 'bank_card') {

            $confirmOrderPaymentCode = hash('sha256', $order->id . time());
            $cancelOrderPaymentCode = hash('sha256', $order->id . random_int(1, 1000));

            $acquiringResult = $bank->orderRegistration(
                $order->id,
                $total_cost,
                $confirmOrderPaymentCode,
                $cancelOrderPaymentCode
            );
            if ($acquiringResult === false || !isset($acquiringResult['orderId'])) {
                return response()->json([
                    'error' => view('flash.index')
                        ->with('error', $acquiringResult['errorMessage'])
                        ->render(),
                ]);
            }
            /* Saved */
            $this->service->order($request, $total_cost, $order->id, $acquiringResult['orderId'], $confirmOrderPaymentCode, $cancelOrderPaymentCode);
            // if successful redirect user to the payment page transfer
            //return redirect()->away($acquiringResult['formUrl']);
            return response()->json(['route' => $acquiringResult['formUrl']]);
        }

        if ($request->get('payment_type') === 'cash') {
            $this->service->order($request, $total_cost, $order->id); /* Saved */
            $orderId = hash_hmac('sha256', $order->id, true);
            return response()->json(['route' => route('order.confirmNoPaid', compact('orderId'))]);
        }
    }

    /**
     * @param Request $request
     * @param CartService $cartService
     * @return Factory|RedirectResponse|View
     */
    public function confirmNoPaid(Request $request, CartService $cartService)
    {
        $orderId = $request->get('orderId'); // hash
        $order = $this->orderRepository->getUserOrder($cartService->getOrder()->id);

        if (!$orderId && !hash_equals($orderId, hash_hmac('sha256', $order->id, true))) {
            return redirect()->route('order.place');
        }

        $order->number = $this->getOrderNumber($order->id);
        $this->data['orderInfo'] = $order;
        $this->sendMail(config('mail.from.address'), $order); // Send mail

        session()->forget('orderId'); // Stay here
        return view('order.info', $this->data, $cartService->getCart());
    }

    /**
     * @param Request $request
     * @param CartService $cartService
     * @return Factory|View
     */
    public function confirmPayment(Request $request, CartService $cartService)
    {
        $acquiringOrderId = $request->get('orderId');
        $confirmOrderPaymentCode = $request->get('confirmOrderPaymentCode');

        if (!$order = $this->orderRepository->confirmPayment($acquiringOrderId, $confirmOrderPaymentCode)) {
            return abort(404);
        }

        $order->order_status = Order::STATUS_PAID;
        $order->confirm_payment_code = null;
        $order->cancel_payment_code = null;
        $order->save();

        $order->number = $this->getOrderNumber($order->id);
        $this->data['orderInfo'] = $order;
        $this->sendMail(config('mail.from.address'), $order);

        session()->forget('orderId');
        return view('order.info', $this->data, $cartService->getCart());
    }

    /**
     * @param Request $request
     * @param CartService $cartService
     * @return RedirectResponse|void
     */
    public function cancelPayment(Request $request, CartService $cartService)
    {
        $acquiringOrderId = $request->get('orderId');
        $cancelOrderPaymentCode = $request->get('cancelOrderPaymentCode');

        if (!$order = $this->orderRepository->cancelPayment($acquiringOrderId, $cancelOrderPaymentCode)) {
            return abort(404);
        }
        $order->order_status = Order::STATUS_CANCEL_PAID;
        $order->save();
        return redirect()->route('order.place')->with('error', __('ErrorPayment'));
    }

    /**
     * @param integer $id
     * @return string
     */
    public function getOrderNumber($id): string
    {
        return '№' . str_pad($id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * @param $string
     * @return mixed
     */
    private function toArray($string)
    {
        return json_decode(preg_replace("/[\r\n]+/", ' ', $string), false);
    }

    /**
     * @param $mail
     * @param Order $order
     */
    private function sendMail($mail, Order $order): void
    {
        $data = $this->mailRender($order);
        $this->mailer->to($mail)->send(new OrderShipped($data, $order));
    }

    private function mailRender($order)
    {
        $data = [];
        $columns = ['Название', 'Цена', 'Количество', 'Сумма'];

        foreach ($order->products as $product) {
            $data[] = [
                $product->title,
                $product->price . ' ' . __('Rub'),
                $product->pivot->count . ' ' . $product->unit_pricing_base_measure,
                round($product->price * $product->pivot->count, 2) . ' ' . __('Rub')
            ];
        }
        return compact('data', 'columns');
    }
}
