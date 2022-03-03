<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\UseCases\Products\PriceService;

class PageController extends Core
{
    /**
     * @var array $data
     */
    protected $data = [];

    public const HOME_PAGE_NAME = 'home';

    /**
     * PageController constructor.
     * @param PriceService $service
     */
    public function __construct(PriceService $service)
    {
        parent::__construct();
        $this->data = [
            'pages'             => $this->pageRepository->getAllPagesNav(),
            'productCategories' => $this->productCategoryRepository->getAllProductCategories(),
            'products'          => $service->subtractPercent($this->productRepository->getAllProducts()),
            'homePageTop'       => $this->productCategoryRepository->getHomePageTop(),
        ];
    }

    /**
     * @param CartService $cartService
     * @return Factory|View|void
     */
    public function index(CartService $cartService)
    {
        //dd(auth()->user()->favorites->count() ?: session('favorites'));
        $page = $this->pageRepository->getFirstPage(self::HOME_PAGE_NAME);
        if (!$page) {
            return abort(404);
        }
        $this->data['page'] = $page;
        return view('pages.home', $this->data, $cartService->getCart());
    }

    /**
     * @param string $slug
     * @param CartService $cartService
     * @return Factory|View|void
     */
    public function page(string $slug, CartService $cartService)
    {
        if (!$page = $this->pageRepository->getFirstPageBySlug($slug)) {
            return abort(404);
        }

        $this->data['page'] = $page;
        $this->data['subPage'] = ($page->children) ? $page->children->first() : $page->parent->children->first();
        return view('page', $this->data, $cartService->getCart());
    }
}
