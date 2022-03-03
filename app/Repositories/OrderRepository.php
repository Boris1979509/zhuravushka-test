<?php


namespace App\Repositories;

use App\Models\Shop\Order as Model;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends CoreRepository
{

    /**
     * Возвращает полное имя класса
     * @return string
     */


    protected function getModelClass(): string
    {
        return Model::class;
    }

    /**
     * @param $order
     * @return mixed
     */
    public function findByOrderId($order)
    {
        return $this->startConditions()
            ->find($order);
    }

    /**
     * @param string $acquiringOrderId
     * @param string $confirmOrderPaymentCode
     * @return mixed
     */
    public function confirmPayment($acquiringOrderId, $confirmOrderPaymentCode)
    {
        return $this->startConditions()
            ->where([
                'order_status' => Model::STATUS_NO_PAID,
                'acquiring_order_id' => $acquiringOrderId,
                'confirm_payment_code' => $confirmOrderPaymentCode,
            ])->with('products')
            ->first();
    }

    /**
     * @param string $acquiringOrderId
     * @param string $cancelOrderPaymentCode
     * @return mixed
     */
    public function cancelPayment($acquiringOrderId, $cancelOrderPaymentCode)
    {
        return $this->startConditions()
            ->where([
                'acquiring_order_id' => $acquiringOrderId,
                'order_status' => Model::STATUS_NO_PAID,
                'cancel_payment_code' => $cancelOrderPaymentCode,
            ])->first();
    }

    /**
     * @param integer $id
     * @return mixed
     */
    public function getUserOrder($id)
    {
        return $this->startConditions()
            ->where('id', $id)
            ->with('products')
            ->first();
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->startConditions()
            ->where('total_cost', '<>', 0)
            ->count();
    }

    /**
     * @param null|integer $per_page
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getAllOrders($per_page = null, $columns = ['*']): LengthAwarePaginator
    {
        return $this->startConditions()
            ->select($columns)
            ->where('total_cost', '<>', 0)
            ->with(['products', 'user'])
            ->paginate($per_page);
    }
}
