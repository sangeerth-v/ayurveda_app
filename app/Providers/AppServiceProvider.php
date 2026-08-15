<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Advertisement;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            if (Schema::hasTable('advertisements')) {
                // Get all active popup advertisements ordered by order_index
                $popupAds = Advertisement::where('is_active', true)
                                ->where('is_popup', true)
                                ->orderBy('order_index', 'asc')
                                ->get();

                $view->with('popupAds', $popupAds);
                $view->with('popupAd', $popupAds->first());
            }
        });
    }
}
