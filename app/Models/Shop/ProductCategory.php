<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class ProductCategory
 * @package App\Models\Shop
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property null|integer $parent_id
 * @property mixed parent
 */
class ProductCategory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title',
        'parent_id',
        'description',
    ];

    /**
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }
    /**
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(ProductPropertyValue::class, 'category_id', 'id');
    }
}
