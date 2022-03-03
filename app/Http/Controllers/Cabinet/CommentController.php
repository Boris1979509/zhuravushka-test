<?php


namespace App\Http\Controllers\Cabinet;


use App\Http\Controllers\Core;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Core
{
    /**
     * @var array
     */
    protected $data = [];

    public function __construct()
    {
        parent::__construct();
        //$this->middleware('auth');
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(CartService $cartService)
    {
        $this->data['user'] = Auth::user();
        return view('cabinet.comment.index', $this->data, $cartService->getCart());
    }
}
