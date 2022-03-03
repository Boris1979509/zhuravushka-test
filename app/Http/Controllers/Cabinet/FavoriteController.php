<?php


namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use App\UseCases\Products\FavoriteService;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class FavoriteController extends Core
{
    /**
     * @var array
     */
    protected $data = [];
    /**
     * @var FavoriteService $service
     */
    private $service;

    public function __construct(FavoriteService $service)
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
        $this->service = $service;
    }

    /**
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        $this->data['products'] = $this->service->getUserFavoriteList();
        return view('cabinet.favorite.index', $this->data, $cartService->getCart());
    }
}
