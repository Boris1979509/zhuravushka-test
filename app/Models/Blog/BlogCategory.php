<?php

namespace App\Models\Blog;

use App\Http\Requests\Admin\Blog\BlogCategoryCreateRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class BlogCategory
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $parent_id
 * @property string $description
 *
 * @property-read BelongsTo $parent
 * @property-read int|null $post_count
 */
class BlogCategory extends Model
{

    use SoftDeletes;

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
        return $this->belongsTo(static::class, 'parent_id', 'id');
    }

    /**
     * @return HasOne
     */
    public function posts(): HasOne
    {
        return $this->hasOne(BlogPost::class, 'category_id', 'id');
    }

    /**
     * @return int|null
     */
    public function getPostCountAttribute(): ?int
    {
        return $this->posts->count ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getParentTitleAttribute()
    {
        return $this->parent->title ?? null;
    }

    /**
     * @param BlogCategoryCreateRequest $request
     * @return mixed
     */
    public static function new(BlogCategoryCreateRequest $request)
    {
        return static::create($request->all());
    }
}
