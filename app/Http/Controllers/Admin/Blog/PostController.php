<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Core;
use App\Models\Blog\BlogPost;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Admin\Blog\BlogPostUpdateRequest;
use Illuminate\View\View;
use App\Http\Requests\Admin\Blog\BlogPostCreateRequest;

class PostController extends Core
{
    /**
     * Per page
     */
    public const LIMIT = 20;
    /**
     * @var array
     */
    protected $data = [];

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @return Factory|View
     */
    public function index()
    {
        $posts = $this->blogPostRepository->getAllWithTrashed(self::LIMIT);
        return view('admin.blog.posts.index', compact('posts'), $this->data);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $item = new BlogPost();
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('admin.blog.posts.create', compact('item', 'categoryList'), $this->data);
    }

    /**
     * @param BlogPostCreateRequest $request
     * @return RedirectResponse|null
     */
    public function store(BlogPostCreateRequest $request): ?RedirectResponse
    {
        try {
            $post = BlogPost::new($request);
            return redirect()
                ->route('admin.blog.posts.edit', $post)
                ->with('success', __('Saved successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param BlogPost $post
     * @return Factory|View
     */
    public function edit(BlogPost $post): View
    {
        $item = $this->blogPostRepository->getEdit($post->id);
        if (!$item) {
            return redirect()->route('admin.blog.posts.index');
        }
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('admin.blog.posts.edit', compact('item', 'categoryList'), $this->data);
    }


    public function update(BlogPostUpdateRequest $request, BlogPost $post)
    {
        $item = $this->blogPostRepository->getEdit($post->id);
        $request = is_null($request->file('image')) ? $request->except('image') : $request->all();
        try {
            $item->update($request);
            return redirect()
                ->route('admin.blog.posts.edit', $post)
                ->with('success', __('Updated successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id): RedirectResponse
    {
        // $item = BlogPost::find($id)->forceDelete();
        // Soft deleted
        if ($item = BlogPost::destroy($id)) {
            return redirect()
                ->route('admin.blog.posts.index')
                ->with('success', __('Deleted successfully'));
        }
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        $post = $this->blogPostRepository->getRestore($id);
        if ($post->restore()) {
            return redirect()
                ->route('admin.blog.posts.index')
                ->with('success', __('Restored successfully'));
        }
    }
}
