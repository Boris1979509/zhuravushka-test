<?php

namespace App\Observers;

use App\Models\Blog\BlogCategory;
use Illuminate\Support\Str;

class BlogCategoryObserver
{

    /**
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function creating(BlogCategory $blogCategory): void
    {
        $this->setSlug($blogCategory);
    }


    /**
     * @param BlogCategory $blogCategory
     * @return void
     */
    public function updating(BlogCategory $blogCategory): void
    {
        $this->setSlug($blogCategory);
    }


    public function deleting(BlogCategory $blogCategory): void
    {

    }


    public function restored(BlogCategory $blogCategory)
    {
        //
    }


    public function forceDeleted(BlogCategory $blogCategory)
    {
        //
    }

    /**
     * @param BlogCategory $blogCategory
     */
    private function setSlug(BlogCategory $blogCategory)
    {
        // If field title was changed or title is empty
        if (empty($blogCategory->slug) || $blogCategory->isDirty('title')) {
            $blogCategory->slug = Str::slug($blogCategory->title, '-');
        }
    }
}
