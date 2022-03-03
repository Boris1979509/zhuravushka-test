<?php

namespace App\Http\Controllers\Admin\Blog;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core;
use App\Http\Requests\Admin\Blog\BlogCategoryCreateRequest;
use App\Http\Requests\Admin\Blog\BlogCategoryUpdateRequest;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogPost;
use App\Repositories\BlogPostRepository;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Core
{
    /**
     * @var array $data
     */
    protected $data = [];

    /**
     * CategoryController constructor.
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
        $categories = $this->blogCategoryRepository->getWithTrashed();
        return view('admin.blog.categories.index', compact('categories'), $this->data);
    }


    /**
     * @return Factory|View
     */
    public function create()
    {
        $category = new BlogCategory();
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('admin.blog.categories.create', compact('category', 'categoryList'), $this->data);
    }


    /**
     * @param BlogCategoryCreateRequest $request
     * @return RedirectResponse
     */
    public function store(BlogCategoryCreateRequest $request)
    {
        try {
            BlogCategory::new($request);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()
            ->route('admin.blog.categories.index')
            ->with('success', __('Saved successfully'));
    }


    public function show($id)
    {
        //
    }


    /**
     * @param BlogCategory $category
     * @return Factory|View
     */
    public function edit(BlogCategory $category)
    {
        $categoryList = $this->blogCategoryRepository->getForComboBox();
        return view('admin.blog.categories.edit', compact('category', 'categoryList'), $this->data);
    }


    /**
     * @param BlogCategoryUpdateRequest $request
     * @param BlogCategory $category
     * @return RedirectResponse
     */
    public function update(BlogCategoryUpdateRequest $request, BlogCategory $category)
    {
        try {
            $category->update($request->all());
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
        return redirect()
            ->route('admin.blog.categories.edit', $category)
            ->with('success', __('Saved successfully'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        if (!$item = $this->blogCategoryRepository->getEdit($id)) {
            return redirect()->back();
        }

        try {
            // $item->posts()->update(['is_published' => 0, 'published_at' => null]);
            // $item->posts()->delete();
            $item->delete();
            return redirect()
                ->route('admin.blog.categories.index')
                ->with('success', __('Deleted successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function restore($id): RedirectResponse
    {
        if (!$category = $this->blogCategoryRepository->getRestore($id)) {
            return redirect()->back();
        }
        if ($category->restore()) {
            return redirect()
                ->route('admin.blog.categories.index')
                ->with('success', __('Restored successfully'));
        }
    }
}
