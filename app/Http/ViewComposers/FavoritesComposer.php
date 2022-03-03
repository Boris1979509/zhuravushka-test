<?php


namespace App\Http\ViewComposers;


use Illuminate\View\View;
use App\UseCases\Products\FavoriteService;

class FavoritesComposer
{
    /**
     * @var FavoriteService $favoriteService
     */
    protected $favoriteService;

    /**
     * ComparesComposer constructor.
     * @param FavoriteService $favoriteService
     */
    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    /**
     * @param View $view
     * @return View
     */
    public function compose(View $view)
    {
        $favorites = $this->favoriteService->getUserFavoriteList();
        if ($favoriteCount = $favorites) {
            $favoriteCount = $favorites->count();
        } else {
            $favoriteCount = 0;
        }
        return $view->with(compact('favorites', 'favoriteCount'));
    }
}
