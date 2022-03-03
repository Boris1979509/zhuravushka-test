<?php


namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class OrderController extends Core
{
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
        $userId = Auth::id();
        $this->data['user'] = $this->userRepository->findUserWithOrdersProducts($userId);
        return view('cabinet.order.index', $this->data, $cartService->getCart());
    }
}
