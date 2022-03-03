<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class BlogController extends Core
{
    // Paginate
    public const LIMIT = 10;
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
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        $this->data['paginator'] = $this->blogPostRepository->getAllWithPaginate(self::LIMIT);
        return view('blog.index', $this->data, $cartService->getCart());
    }

    /**
     * @param string $slug
     * @param CartService $cartService
     * @return View
     */
    public function getByCategory(string $slug, CartService $cartService): view
    {
        $this->data['category'] = $this->blogCategoryRepository->getCategoryBySlug($slug);
        $this->data['paginator'] = $this->blogPostRepository
            ->getAllWithPaginate(self::LIMIT, $this->data['category']->id);

        return view('blog.index', $this->data, $cartService->getCart());
    }
}
