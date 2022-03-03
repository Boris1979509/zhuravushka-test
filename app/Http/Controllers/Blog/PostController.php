<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class PostController extends Core
{
    /**
     * @var array $data
     */
    protected $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['blogCategories'] = $this->BlogCategories();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param string $slug
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(string $slug, CartService $cartService)
    {
        $this->data['post'] = $this->blogPostRepository->getPostBySlug($slug);
        return view('blog.post', $this->data, $cartService->getCart());
    }
}
