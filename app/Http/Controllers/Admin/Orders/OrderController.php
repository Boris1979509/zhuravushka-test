<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Core
{
    /**
     * Per page
     */
    public const PER_PAGE = 5;
    /**
     * @var array $data
     */
    protected $data = [];

    /**
     * OrderController constructor.
     */
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
        $this->data['orders'] = $this->orderRepository->getAllOrders(self::PER_PAGE);
        return view('admin.orders.index', $this->data, $cartService->getCart());
    }
}
