<?php


namespace App\Http\ViewComposers;


use App\Repositories\ProductCategoryRepository;
use App\UseCases\Cart\CartService;
use App\UseCases\Products\CompareService;
use Illuminate\View\View;
use App\Repositories\PageRepository;

class ErrorComposer
{
    /**
     * @var CompareService $compareService
     */

    private $pageRepository;

    private $productCategoryRepository;
    /**
     * @var CartService
     */
    private $cartService;

    /**
     * ErrorComposer constructor.
     * @param PageRepository $pageRepository
     * @param ProductCategoryRepository $productCategories
     * @param CartService $cartService
     */
    public function __construct(PageRepository $pageRepository, ProductCategoryRepository $productCategories, CartService $cartService)
    {
        $this->pageRepository = $pageRepository;
        $this->productCategoryRepository = $productCategories;
        $this->cartService = $cartService;
    }

    /**
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        $pages = $this->pageRepository->getAllPagesNav();
        $productCategories = $this->productCategoryRepository->getAllProductCategories();
        return $view->with(compact('pages', 'productCategories'));
    }
}
