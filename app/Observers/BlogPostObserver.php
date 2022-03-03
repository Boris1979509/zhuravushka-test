<?php

namespace App\Observers;

use App\Models\Blog\BlogPost;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogPostObserver
{
    /**
     * @param BlogPost $blogPost
     */
    public function creating(BlogPost $blogPost): void
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->storeImage($blogPost);
    }

    /**
     * @param BlogPost $blogPost
     */
    public function updating(BlogPost $blogPost): void
    {
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->storeImage($blogPost);
    }

    public function deleted(BlogPost $blogPost): void
    {
        //
    }

    public function restored(BlogPost $blogPost): void
    {
        //
    }

    public function forceDeleted(BlogPost $blogPost): void
    {
        //
    }

    /**
     * @param BlogPost $blogPost
     */
    private function setPublishedAt(BlogPost $blogPost): void
    {
        $blogPost->published_at = ($blogPost->is_published) ? Carbon::now() : null;
    }

    /**
     * @param BlogPost $blogPost
     */
    private function setSlug(BlogPost $blogPost): void
    {
        // If field title was changed or title is empty
        if (empty($blogPost->slug) || $blogPost->isDirty('title')) {
            $blogPost->slug = Str::slug($blogPost->title, '-');
        }
    }

    /**
     * @param BlogPost $blogPost
     */
    private function storeImage(BlogPost $blogPost): void
    {
        if ($blogPost->image instanceof UploadedFile) {
            $image = Image::make($blogPost->image);
            //$image->resize(300, 400);
            $fullImageName = $blogPost->slug . '.' . $blogPost->image->extension();
            $imagePath = public_path('images/blog/' . $fullImageName);
            $blogPost->image = $fullImageName;
            $image->save($imagePath);
        }
    }
}
