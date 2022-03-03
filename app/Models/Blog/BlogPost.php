<?php

namespace App\Models\Blog;

use App\Http\Requests\Admin\Blog\BlogPostCreateRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Class BlogPost
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $excerpt
 * @property string $content
 * @property bool $is_published
 * @property string $published_at
 * @property string $image
 * @property BlogCategory $category_id
 * @property-read  BlogCategory $date_format
 * @property-read  BlogCategory $limit_content
 */
class BlogPost extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'category_id',
        'slug',
        'content',
        'is_published',
        'image',
        'deleted_at',
        'published_at',
        'excerpt',
    ];

    /**
     * @param BlogPostCreateRequest $request
     * @return mixed
     */
    public static function new(BlogPostCreateRequest $request)
    {
        return static::create($request->all());
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id', 'id');
    }


    /**
     * Accessor
     * @return string
     */
    public function getDateFormatAttribute(): string
    {
        return Carbon::parse($this->published_at)->format('d.m.Y');
    }

    /**
     * @return string
     */
    public function getLimitContentAttribute(): string
    {
        return Str::limit($this->content, 150);
    }
}
