<?php

namespace App\Providers;

use App\Http\ViewComposers\ComparesComposer;
use App\Http\ViewComposers\ErrorComposer;
use App\Http\ViewComposers\FavoritesComposer;
use App\Http\ViewComposers\NavComposer;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // view()->composer(['components.header', 'components.footer', 'components.barMenu', 'components.pageNavMenu'], NavComposer::class);
        view()->composer([
            'components.sub-header-navbar',
            'shop.cardIconFavorite',
            'shop.favorite',
        ], FavoritesComposer::class);
        view()->composer([
            'components.sub-header-navbar',
            'shop.cardIconCompare',
            'shop.compare'
        ], ComparesComposer::class);
        //view()->composer(['errors.404', 'components.header', 'components.footer'], ErrorComposer::class);
    }
}
