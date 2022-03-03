<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Order
 * @package App\Models\Shop
 * @property  integer $id
 * @property string $order_status
 * @property string $user_data
 * @property string $comment
 * @property double $total_cost
 * @property integer $user_id
 * @property string $acquiring_order_id
 * @property string $number №00000020
 * @property string $confirm_payment_code
 * @property string $cancel_payment_code
 * @property BelongsToMany $products
 */
class Order extends Model
{
    public const STATUS_PAID = 'paid';
    public const STATUS_NO_PAID = 'no_paid';
    public const STATUS_CANCEL_PAID = 'cancel_paid';

    protected $casts = [
        'user_data' => 'array',
    ];

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function updateOrder(array $data, int $id): bool
    {
        return static::where('id', $id)
            ->update($data);
    }

    /**
     * @return belongsToMany
     */
    public function products(): belongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('count')->withTimestamps();
    }

    /**
     * @return int|float
     */
    public function getTotalSum()
    {
        $total = 0;
        /** @var Product $item */
        foreach ($this->products as $item) {
            $total += $item->getItemTotalSum();
        }
        return $total;
    }

    /**
     * @param $product
     * @return mixed
     */
    public function pivot($product)
    {
        return $this->products()
            ->where('product_id', $product->id)
            ->first()
            ->pivot;
    }

    /**
     * @return int
     */
    public function cartCount(): int
    {
        return $this->products()->count();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getOrderNumber(): string
    {
        return '№' . str_pad($this->id, 8, '0', STR_PAD_LEFT);
    }

    /**
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->order_status === self::STATUS_PAID;
    }
}
