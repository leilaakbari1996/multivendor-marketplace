<?php

namespace App\Providers;

use App\Queries\CartQuery;
use App\View\Composers\CartComposer;
use App\View\Composers\MenuComposer;
use App\View\Composers\NavigationComposer;
use App\View\Composers\SiteSettingsComposer;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->scoped(CartQuery::class);
        $this->app->scoped(CartComposer::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        View::composer(
            'client.layouts.app',
            SiteSettingsComposer::class
        );

        View::composer(
           'client.layouts.app',
            NavigationComposer::class
        );

        View::composer(['components.client.product-card','client.layouts.app'], CartComposer::class);

    }
}
