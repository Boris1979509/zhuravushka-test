<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    const NEW_ORDER = 1;

    const COMPLETED = 2;

    const NEW_ORDER_NO_PAID = 3;

    const NEW_ORDER_PAID = 4;

    const NEW_ORDER_CANCEL_PAID = 5;

    public function orders()
    {
        return $this->hasMany();
    }
}

