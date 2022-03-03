<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core;
use App\Models\Shop\Product;
use App\UseCases\Cart\CartService;
use App\UseCases\Products\CompareService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CompareController extends Core
{
    /**
     * @var FavoriteService $service
     */
    private $service;
    /**
     * @var array $data
     */
    private $data = [];

    /**
     * CompareController constructor.
     * @param CompareService $service
     */
    public function __construct(CompareService $service)
    {
        parent::__construct();
        //$this->middleware('auth');
        $this->service = $service;
    }


    /**
     * Compare
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();

        $this->data['products'] = $this->service->getUserCompareList();
        return view('shop.compare', $this->data, $cartService->getCart())->with('info', __('IsEmptyCompareMessage'));
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
                'status' => 'success',
                'count' => $this->service->count(),
                'message' => $product->title . ' ' . __('Product added to your compare.'),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'status' => 'error',
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
                'status' => 'success',
                'count' => $this->service->count(),
                'message' => $product->title . ' ' . __('Product deleted to your compare.'),
            ]);
        } catch (\DomainException $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}
