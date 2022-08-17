<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Support\Facades\Cache;

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
        \View::composer('*', function($view) {
            $cashTime = 5;

            $view->with(
                'currentUser',
                auth()->user()
            );

            $view->with(
                'headerCategories',
                Cache::remember('headerCategories', $cashTime, function() {
                    return Category::where('in_menu', true)->orderBy('order')->get();
                })
            );
        });
    }
}
