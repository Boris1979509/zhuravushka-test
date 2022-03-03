<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Core;
use App\Http\Requests\ProductsFilterRequest;
use App\Models\Shop\ProductCategory;
use App\Models\Shop\ProductProperty;
use App\UseCases\Cart\CartService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class ProductCategoryController extends Core
{
    /**
     * @var array $data
     */
    protected $data = [];
    /**
     * Paginate limit
     */
    public const PAGE_LIMIT = 18;

    public function __construct()
    {
        parent::__construct();
        $this->data['pages'] = $this->pageRepository->getAllPagesNav();
        $this->data['productCategories'] = $this->productCategoryRepository->getAllProductCategories();
    }

    /**
     * Show all catalog
     * @param CartService $cartService
     * @return View
     */
    public function index(CartService $cartService): View
    {
        return view('shop.catalog', $this->data, $cartService->getCart());
    }

    /**
     * @param ProductsFilterRequest $request
     * @param $slug
     * @param CartService $cartService
     * @return Factory|RedirectResponse|View
     */
    public function category(ProductsFilterRequest $request, $slug, CartService $cartService)
    {

        $category = $this->productCategoryRepository->getBySlug($slug);

        $attributes = $this->productAttributeRepository->getAttributes($category);

        $categoryIds = $this->getAllCategoryIds($category);

        $this->data['products'] = $this->productRepository
            ->whereIn($categoryIds ?: $category, self::PAGE_LIMIT);

        // Stocks
        $this->sortStock($request, $categoryIds ?: $category);

        // Sort
        $this->sort($request, $categoryIds ?: $category);

        // Sort by price
        $this->sortByPrice($request, $categoryIds ?: $category);

        // Sort by Attributes
        $this->sortAttributes($request, $categoryIds ?: $category);

        $this->data['category'] = $category;

        if (is_null($this->data['category'])) {
            return redirect()->route('catalog');
        }
        // if empty sort products
        if (!$this->data['products']->total()) {
            return redirect()->route('category', $slug)->with('info', __('NotFound'));
        }
        return view('shop.category', array_merge($this->data, $cartService->getCart()), compact('attributes'));
    }

    /**
     * @param $category
     * @return mixed
     */
    private function getAllCategoryIds($category)
    {

        if (($category->children)->count()) {
            // if is children
            return $category->children->map(static function ($categoryItem) {
                return $categoryItem->id;
            });
        }
    }

    /**
     * Sort
     * @param $request
     * @param $id
     * @return void
     */
    private function sort($request, $id): void
    {
        if ($sort = $request->input('sort')) {
            $this->data['products'] = $this->productRepository
                ->sortBy($sort, $id, self::PAGE_LIMIT)
                ->withPath('?' . $request->getQueryString());
        }
    }

    /**
     * @param $request
     * @param $id
     */
    private function sortStock($request, $id): void
    {
        /**
         * Stocks
         */
        if ($request->has('sortInStock')) {

            $this->data['products'] = $this->productRepository
                ->sortByStock($id, self::PAGE_LIMIT)
                ->withPath('?' . $request->getQueryString());
        }
    }

    /**
     * @param ProductsFilterRequest $request
     * @param mixed $category
     */
    private function sortAttributes(ProductsFilterRequest $request, $category): void
    {
        $dataAttr = $this->getAttributes($request);
        $priceFrom = $request->anyFilled('priceFrom');
        $priceTo = $request->anyFilled('priceTo');
        $query = null;
        if ($priceFrom || $priceTo || $dataAttr) {

            $query = $this->productAttributeRepository->query(); // Builder

            $query->select('product_id');
            if ($category instanceof ProductCategory) {
                $query->where('category_id', $category->parent_id)
                    ->where('sub_category_id', $category->id);
            }
            if ($category instanceof Collection) {
                $query->whereIn('sub_category_id', $category);
            }

            if ($query->exists()) {

                /* Sort attributes */
                if ($dataAttr) {
                    $query->where(static function ($query) use ($dataAttr) {
                        $query->whereIn('product_property_id', $dataAttr['property_id']);
                        $query->whereIn('product_property_value_id', array_merge(...$dataAttr['values']));
                    });
                    $query->groupBy('product_id')
                        ->havingRaw('count(*) = ' . count($dataAttr['property_id']));
                }
                /* End sort attributes */

                /* Sort price from */
                if ($priceFrom) {
                    $this->sortPriceFrom($query, $request);
                }

                /* Sort price to */
                if ($priceTo) {
                    $this->sortPriceTo($query, $request);
                }

                /* Price from && Price to */
                if ($priceFrom && $priceTo) {
                    $this->sortPriceFromAndTo($query, $request);
                }

                $result = $query->get();

                /* Product id's */
                $productIds = $result->map(static function ($item) {
                    return $item->product_id;
                });

                $this->data['products'] = $this->productRepository
                    ->getFiltersAttributes($productIds, self::PAGE_LIMIT)
                    ->withPath('?' . $request->getQueryString());

            }
        }
    }

    /**
     * @param ProductsFilterRequest $request
     * @return array
     */
    private
    function getAttributes(ProductsFilterRequest $request): array
    {
        $properties = ProductProperty::all();

        $data = [];
        foreach ($request->input() as $key => $name) {
            if ($property = $properties->where('slug', $key)->first()) {
                $data['property_id'][] = $property->id;
                $data['values'][] = $name;
            }
        }
        return $data;
    }

    /**
     * @param Builder $query
     * @param ProductsFilterRequest $request
     */
    private
    function sortPriceFrom(Builder $query, ProductsFilterRequest $request): void
    {
        $from = $request->input('priceFrom');
        $query->whereHas('product', static function ($query) use ($from) {
            $query->where('price', '>=', $from);
        });
    }

    /**
     * @param Builder $query
     * @param ProductsFilterRequest $request
     */
    private
    function sortPriceTo(Builder $query, ProductsFilterRequest $request): void
    {
        $to = $request->input('priceTo');
        $query->whereHas('product', static function ($query) use ($to) {
            $query->where('price', '<=', $to);
        });
    }

    /**
     * @param Builder $query
     * @param ProductsFilterRequest $request
     */
    private
    function sortPriceFromAndTo(Builder $query, ProductsFilterRequest $request): void
    {
        $from = $request->input('priceFrom');
        $to = $request->input('priceTo');
        $query->whereHas('product', static function ($query) use ($from, $to) {
            $query->whereBetween('price', [$from, $to]);
        });
    }

    /**
     * Sort price inputs
     * @param ProductsFilterRequest $request
     * @param mixed $category
     */
    private function sortByPrice(ProductsFilterRequest $request, $category)
    {
        $result = null; // Result data

        if ($request->anyFilled('priceFrom')) {
            $from = $request->input('priceFrom');
            $result = $this->productRepository
                ->getPriceSort($category, $from, '>=', self::PAGE_LIMIT);
        }

        if ($request->anyFilled('priceTo')) {
            $to = $request->input('priceTo');
            $result = $this->productRepository
                ->getPriceSort($category, $to, '<=', self::PAGE_LIMIT);
        }

        if ($request->anyFilled('priceTo') && $request->anyFilled('priceFrom')) {
            $from = $request->input('priceFrom');
            $to = $request->input('priceTo');
            $result = $this->productRepository
                ->getPriceSort($category, [$from, $to], null, self::PAGE_LIMIT);
        }
        if($result){
            $this->data['products'] = $result->withPath('?' . $request->getQueryString());
        }
    }

}
