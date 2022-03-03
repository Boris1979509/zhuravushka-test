<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProductAttribute
 * @package App\Models\Shop
 * @property int $category_id
 * @property int $product_id
 * @property int $product_property_id
 * @property int $product_property_value_id
 */
class ProductAttribute extends Model
{
    protected $fillable = [
        'category_id',
        'product_id',
        'product_property_id',
        'product_property_value_id',
    ];

    /**
     * @return BelongsTo
     */
    public function property(): BelongsTo
    {
        return $this->belongsTo(ProductProperty::class, 'product_property_id');
    }

    /**
     * @return BelongsTo
     */
    public function value(): BelongsTo
    {
        return $this->belongsTo(ProductPropertyValue::class, 'product_property_value_id');
    }

    /**
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
