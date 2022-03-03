<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 * @package App\Models\Shop
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property float|int $price
 * @property string $photo
 * @property string $photo_thumb
 * @property integer $category_id
 * @property string $description
 * @property integer|int $quantity
 * @property BelongsToMany $pivot
 * @property string $unit_pricing_base_measure
 */
class Product extends Model
{
    use softDeletes;
    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'code',
        'price',
        'slug',
        'quantity',
        'unit_pricing_base_measure',
        'article',
        'photo',
        'photo_thumb',
        'description',
        'category_id',
    ];
    protected $casts = [
        'price'    => 'float',
        'quantity' => 'float',
    ];

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function favorites(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'product_favorites', 'product_id', 'user_id');
    }

    /**
     * @return float
     */
    public function getItemTotalSum(): float
    {
        if (!is_null($this->pivot)) {
            return $this->pivot->count * $this->price;
        }
    }

    /**
     * @param Builder $query
     * @param User $user
     * @return Builder
     */
    public function scopeFavoredByUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('favorites', static function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    /**
     * @return int
     */
    public function favoriteCount(): int
    {
        return $this->favorites()->count();
    }

    /**
     * @return Relation
     */
    public function visits()
    {
        return visits($this)->relation();
    }

    /**
     * @return HasMany
     */
    public function attributes(): HasMany
    {
        return $this->hasMany(ProductAttribute::class, 'product_id');
    }
}
