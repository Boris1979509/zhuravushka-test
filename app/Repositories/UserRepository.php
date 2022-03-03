<?php


namespace App\Repositories;

use App\Models\User as Model;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository extends CoreRepository
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
     * @param string $phone
     * @return mixed
     */
    public function phoneVerified($phone)
    {
        return $this->startConditions()
            ->select('phone_verified_status')
            ->where('phone', $phone);
    }

    /**
     * @param int $user_id
     * @return mixed
     */
    public function find($user_id)
    {
        return $this->startConditions()
            ->where('id', $user_id)->first();
    }

    /**
     * @param integer $user_id
     * @return mixed
     */
    public function findUserWithOrdersProducts($user_id)
    {
        return $this->startConditions()
            ->where('id', $user_id)
            ->with(['orders' => static function ($query) {
                $query->with('products');
            }])
            ->first();
    }

    /**
     * @return Builder
     */
    public function OrderByDesc(): Builder
    {
        return $this->startConditions()
            ->OrderByDesc('id');
    }

    /**
     * @return mixed
     */
    public function all()
    {
        return $this->startConditions()
            ->count();
    }
}
