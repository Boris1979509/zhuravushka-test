<?php


namespace App\Http\ViewComposers;


use App\UseCases\Products\CompareService;
use Illuminate\View\View;

class ComparesComposer
{
    /**
     * @var CompareService $compareService
     */
    protected $compareService;

    /**
     * ComparesComposer constructor.
     * @param CompareService $compareService
     */
    public function __construct(CompareService $compareService)
    {
        $this->compareService = $compareService;
    }

    /**
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        $compares = $this->compareService->getUserCompareList();
        if ($compareCount = $compares) {
            $compareCount = $compares->count();
        } else {
            $compareCount = 0;
        }
        return $view->with(compact('compares', 'compareCount'));
    }
}
