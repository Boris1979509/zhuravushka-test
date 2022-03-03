<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Core;
use App\Models\Shop\Product;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class CartController extends Core
{
    public const PAGE = 3;
    /**
     * @var array $data
     */
    protected $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        // $this->data['products'] = $cartService->productsPaginate(self::PAGE);
        return view('shop.userCart', array_merge($this->data, $cartService->getCart()), compact('cartService'));
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function add(Product $product, Request $request): JsonResponse
    {
        if (!$request->wantsJson()) {
            abort(400);
        }
        $this->data = (new CartService(true))->add($product, $request);
        return response()->json($this->data);
    }

    /**
     * @param Product $product
     * @param Request $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function remove(Product $product, Request $request): JsonResponse
    {
        if (!$request->wantsJson()) {
            abort(400);
        }
        $this->data = (new CartService(true))->remove($product, $request);
        return response()->json($this->data);
    }
}
