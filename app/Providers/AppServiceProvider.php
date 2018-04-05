<?php

namespace App\Providers;

use App\Services\CachedPricingService;
use App\Services\PricingService;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Blade;

use Auth;


class AppServiceProvider extends ServiceProvider


{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('admin', function () {
            return Auth::check() && Auth::user()->role == 'admin';
        });

        $this->app->singleton(PricingService::class, function($app) {
            return $app->make(CachedPricingService::class);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
