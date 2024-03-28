<?php

namespace App\Providers;

use App\Models\Menu;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        View::composer('*', function ($view) {
            $navbars = Menu::with('active_children')->doesntHave('parent')->where('is_active', true)->orderBy('order')->get();
            $view->with('navbars', $navbars);
        });
    }
}
