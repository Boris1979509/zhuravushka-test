<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Page
 * @package App\Models\Shop
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property string $content
 * @property string $description
 *
 * @property Page $parent
 * @property Page[] $children
 */
class Page extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'description',
        'parent_id',
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
}
