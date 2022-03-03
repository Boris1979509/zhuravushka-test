<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryProperty
 * @package App\Models\Shop
 * @property integer $id
 * @property integer $category_id
 * @property integer $product_property_id
 */
class CategoryProperty extends Model
{
    protected $table = 'category_property';
    protected $fillable = [
        'category_id',
        'product_property_id',
    ];
}
