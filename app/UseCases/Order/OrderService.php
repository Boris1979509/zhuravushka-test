<?php

namespace App\UseCases\Order;

use App\Models\Shop\Order;
use App\UseCases\Auth\PhoneService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * @var PhoneService $phoneService
     */
    private $service;

    public function __construct(PhoneService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param integer $total_cost
     * @param integer $id
     * @param null|string $acquiring_order_id
     * @param null|string $confirmOrderPaymentCode
     * @param null|string $cancelOrderPaymentCode
     * @return bool
     */
    public function order(Request $request, $total_cost, $id, $acquiring_order_id = null, $confirmOrderPaymentCode = null, $cancelOrderPaymentCode = null): bool
    {
        $data = [
            'user_id'              => Auth::id(),
            'total_cost'           => $total_cost,
            'order_status'         => Order::STATUS_NO_PAID,
            'acquiring_order_id'   => $acquiring_order_id,
            'confirm_payment_code' => $confirmOrderPaymentCode,
            'cancel_payment_code'  => $cancelOrderPaymentCode,
            'user_data'            => [
                'contacts'       => [
                    'name'        => Str::ucfirst($request['name']),
                    'last_name'   => Str::ucfirst($request['last_name']),
                    'middle_name' => Str::ucfirst($request['middle_name']),
                    'email'       => $request['email'],
                    'phone'       => $request['phone'],
                ],
                'delivery_place' => [
                    'city'         => $request['city'],
                    'street'       => $request['street'],
                    'house_number' => $request['house_number'],
                    'apartment'    => $request['apartment'],
                ],
                'delivery_type'  => $request['delivery_type'],
                'date_time'      => [
                    'delivery_date' => $request['delivery_date'],
                    'delivery_time' => $request['delivery_time'],
                ],
            ],
            'comment'              => $request['message'],
        ];
        return Order::updateOrder($data, $id);
    }

    /**
     * @return void
     */
    public function forget(): void
    {
        $this->service->forget();
    }
}
