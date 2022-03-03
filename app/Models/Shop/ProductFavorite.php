<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductFavorite
 * @package App\Models
 * @property integer $id
 * @property integer $product_id
 * @property integer $user_id
 */
class ProductFavorite extends Model
{
    use SoftDeletes;
    /**
     * @var array $fillable
     */
    protected $fillable = [
        'product_id',
        'user_id',
    ];
    /**
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
