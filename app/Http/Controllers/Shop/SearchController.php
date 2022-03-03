<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Core;
use App\Models\Shop\Product;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Core
{
    /**
     * @var array $data
     */
    private $data = [];
    public const PER_PAGE = 20;

    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * @param Request $request
     * @param CartService $cartService
     * @return Factory|View
     */
    public function index(Request $request, CartService $cartService)
    {

        $query = $this->productRepository->query();
        if (!is_null($value = $request->input('search'))) {
            $this->data['products'] = $query->where('title', 'like', '%' . $value . '%')
                ->paginate(self::PER_PAGE)
                ->withPath('?' . $request->getQueryString());
        }

        return view('shop.search', $this->data, $cartService->getCart());
    }

    public function search(Request $request)
    {
        if (!$request->wantsJson()) {
            abort(404);
        }
        $result = [];
        if (!is_null($value = $request->input('search'))) {
            $result = Product::where('title', 'like', '%' . $value . '%')->get();
        }

        collect($result)->map(static function ($item) {
            $item->photo = fileExist('images/products/' . $item->photo);
            $item->price = numberFormat($item->price);
        });

        return response()->json($result);
    }
}
