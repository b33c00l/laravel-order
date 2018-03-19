<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;
use App\Http\ViewComposers\SidebarComposer;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.main', SidebarComposer::class);
        View::composer('layouts.page', SidebarComposer::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
