<?php

namespace App\UseCases\Cart;


use App\Models\Shop\Order;
use App\Repositories\OrderRepository;
use App\Models\Shop\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Throwable;

class CartService
{
    /**
     * @var Order $order
     */
    protected $order;

    /**
     * CartService constructor.
     * @param bool $orderCreated
     */
    public function __construct($orderCreated = false)
    {
        $this->load($orderCreated);
    }

    /**
     * @param bool $orderCreated
     */
    public function load($orderCreated): void
    {
        $order = session('orderId');
        if (is_null($order) && $orderCreated) {
            $this->order = Order::create();
            session(['orderId' => $this->order->id]);
        } else {
            $this->order = (new OrderRepository())->findByOrderId($order);
        }
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return array
     * @throws Throwable
     */
    public function add(Product $product, Request $request): array
    {
        if ($this->order->products->contains($product)) {
            $inc = $request->input('inc'); // increments ++ --
            $result = $this->pivotCount($this->order->pivot($product), $product, $inc);
        } else {
            $result = ['status' => 'success', 'message' => 'Товар ' . $product->title . ' упешно добавлен в корзину.'];
            $this->order->products()->attach($product);
        }
        if ($request->wantsJson()) {
            return [
                    'cartItemTotalSum' => $this->numberFormat($this->order->products()->find($product)->getItemTotalSum()),
                    'dataMsg' => $result,
                ] + $this->getCart();
        }
    }

    /**
     * @param $pivot
     * @param Product $product
     * @param $inc
     * @return array|string
     * @throws Throwable
     */
    public function pivotCount($pivot, $product, $inc)
    {
        if ($this->order) {
            $message = '';
            switch ($inc) {
                case '++':
                    $pivot->count++;
                    if ($underOrder = $this->underOrder($pivot, $product)) {
                        $message = [
                            'status'          => 'info',
                            'message'         => 'Доступно '
                                . $underOrder['string_quantity']
                                . ' в наличии + ' . $underOrder['string_under_order']
                                . ' под заказ.',
                            'underOrder'      => view('shop.underOrder.underOrder', compact('underOrder'))->render(),
                            'underOrderTotal' => view('shop.underOrder.underOrderTotal', compact('underOrder'))->render(),
                        ];
                    } else {
                        $message = [
                            'status'  => 'success',
                            'message' => 'Товар ' . $product->title . ' упешно добавлен в корзину.',
                        ];
                    }
                    break;
                case '--':
                    $pivot->count--;
                    if ($underOrder = $this->underOrder($pivot, $product)) {
                        $message = [
                            'status'          => 'info',
                            'message'         => 'Доступно '
                                . $underOrder['string_quantity']
                                . ' в наличии + ' . $underOrder['string_under_order']
                                . ' под заказ.',
                            'underOrder'      => view('shop.underOrder.underOrder', compact('underOrder'))->render(),
                            'underOrderTotal' => view('shop.underOrder.underOrderTotal', compact('underOrder'))->render(),
                        ];
                    } else {
                        $message = [
                            'status'  => 'success',
                            'message' => 'Товар ' . $product->title . ' упешно удален из корзины.',
                        ];
                    }
                    break;
                case 'input':
                    break;
            }
            if ($pivot->count < 1) {
                $this->order->products()->detach($product);
            }
            $pivot->update();
            return $message;
        }
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return array
     * @throws Throwable
     */
    public function remove(Product $product, Request $request): array
    {
        $this->order->products()->detach($product);
        if (!$this->order->cartCount()) {
            $this->order->forceDelete();
            session()->forget('orderId');
            return [
                'dataMsg' => [
                    'status'  => 'success',
                    'message' => __('CartEmptyMessage'),
                ],
                'view'    => view('shop.cart', [])->render(),
            ];
        }
        return [
                'dataMsg' => [
                    'status'  => 'success',
                    'message' => 'Товар ' . $product->title . ' упешно удален из корзины.',
                ],
            ] + $this->getCart();
    }

    /**
     * @return array
     */
    public function getCart(): array
    {
        if (is_null($this->order)) {
            return [];
        }
        return [
            'order'        => $this->order,
            'cartCount'    => $this->order->cartCount(),
            'cartTotalSum' => $this->numberFormat($this->getTotalSum()),
        ];
    }

    /**
     * @param float|integer $price
     * @return mixed
     */
    private function numberFormat($price): string
    {
        $value = number_format($price, 2, '.', ' ');
        $value = str_replace('.00', '', $value);
        return $value;
    }

    /**
     * @return string
     */
    public function getTotalSum(): string
    {
        if ($total = (new OrderRepository())->findByOrderId($this->order->id)->getTotalSum()) {
            return $total;
        }
    }

    /**
     * @param $pivot
     * @param $product
     * @return array|bool
     * @throws Throwable
     */
    public function underOrder($pivot, $product)
    {
        if ($pivot->count > $product->quantity) {
            $count = $pivot->count - $product->quantity;
            return [
                'price'              => $product->price,
                'string_quantity'    => $product->quantity . $product->unit_pricing_base_measure . '.',
                'string_under_order' => $count . $product->unit_pricing_base_measure . '.',
            ];
        }
        return false;
    }

    /**
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function productsPaginate(int $page): LengthAwarePaginator
    {
        return $this->order->products()
            ->orderBy('id', 'DESC')
            ->paginate($page);
    }

}
