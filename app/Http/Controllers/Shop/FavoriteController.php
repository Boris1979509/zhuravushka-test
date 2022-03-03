<?php

namespace App\Http\Controllers\Shop;

use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;
use App\UseCases\Cart\CartService;
use App\UseCases\Products\FavoriteService;
use App\Http\Controllers\Core;
use App\Models\Shop\Product;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class FavoriteController extends Core
{
    /**
     * @var FavoriteService $service
     */
    private $service;
    /**
     * @var array $data
     */
    private $data = [];

    public function __construct(FavoriteService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    /**
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();

        $this->data['products'] = $this->service->getUserFavoriteList();
        return view('shop.favorite', $this->data, $cartService->getCart())->with('info', __('IsEmptyFavoriteMessage'));
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function add(Product $product): ?JsonResponse
    {
        try {
            $this->service->add(Auth::id(), $product->id);
            return response()->json([
                'status'  => 'success',
                'count'  => $this->service->count(),
                'message' => $product->title . ' ' . __('Product added to your favorite.'),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function remove(Product $product): ?JsonResponse
    {
        try {
            $this->service->remove(Auth::id(), $product->id);
            return response()->json([
                'status'  => 'success',
                'count'  => $this->service->count(),
                'message' => $product->title . ' ' . __('Product deleted to your favorite.'),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
