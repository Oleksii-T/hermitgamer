<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Builder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        // \Debugbar::disable();

        \View::composer('*', function($view) {
            $cashTime = 5;
            $user = auth()->user();

            $view->with('currentUser', $user);

            $view->with(
                'headerCategories',
                Cache::remember('headerCategories', $cashTime, function() {
                    return Category::where('in_menu', true)->orderBy('order')->get();
                })
            );

            $data = [
                'csrf' => csrf_token(),
                'route_name' => \Route::currentRouteName(),
                'translations' => [],
                'recaptcha_key' => config('services.recaptcha.public_key'),
            ];
            $translationsForJs = [

            ];
            foreach ($translationsForJs as $t) {
                $data['translations'][str_replace('.', '_', $t)] = trans($t);
            }
            if ($user) {
                $data['user'] = [
                    'name' => $user->name,
                    'email' => $user->email
                ];
            }
            $view->with('LaravelDataForJS', json_encode($data));
        });

        \Blade::directive('svg', function($arguments) {
            // Funky madness to accept multiple arguments into the directive
            list($path, $class) = array_pad(explode(',', trim($arguments, "() ")), 2, '');
            $path = trim($path, "' ");
            $class = trim($class, "' ");

            // Create the dom document as per the other answers
            $svg = new \DOMDocument();
            $svg->load(public_path($path));
            $svg->documentElement->setAttribute("class", $class);
            $output = $svg->saveXML($svg->documentElement);

            return $output;
        });

        // Paginator::defaultView('components.pagination');

        Carbon::mixin(new class {
            public function adminFormat()
            {
                return function () {
                    return $this->format('d/m/Y H:i');
                };
            }
        });
    }
}
