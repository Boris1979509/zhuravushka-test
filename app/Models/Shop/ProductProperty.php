<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ProductProperties
 * @package App\Models\Shop
 * @property integer $id
 * @property string $title
 * @property string $slug
 */
class ProductProperty extends Model
{
    use softDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
    ];
    /**
     * @return HasMany
     */
    public function properties(): hasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_property_id');
    }

    /**
     * @return HasMany
     */
    public function values(): hasMany
    {
        return $this->hasMany(ProductPropertyValue::class, 'product_property_id', 'id');
    }
}
