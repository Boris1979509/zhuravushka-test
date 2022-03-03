<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Models\Shop\Product;
use Illuminate\View\View;
use App\UseCases\Products\PriceService;

class ProductController extends Core
{
    /**
     * @var array $data
     */
    protected $data = [];
    /**
     * @var PriceService $service
     */
    private $service;

    public function __construct(PriceService $service)
    {
        parent::__construct();
        $this->service = $service;
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
        $this->data['products'] = $this->productRepository->getAllProducts();

    }

    /**
     * @param $slug
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index($slug, CartService $cartService)
    {
        /**
         * @var Product $product
         */
        if (!$product = $this->productRepository->getBySlug($slug)) {
            return abort(404);
        }
        $this->data['product'] = $product;
        $this->data['moreGoods'] = $this->productRepository->getMoreGoods($product);
        $this->data['product']['old_price'] = $this->service->subtractPercent($product->price);
        return view('shop.product', $this->data, $cartService->getCart());
    }
}
