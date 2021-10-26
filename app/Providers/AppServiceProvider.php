<?php

namespace App\Providers;


use Blade;
use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\ActivityComposer;


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
        Blade::component('components.badge', 'badge');
        Blade::component('components.updated', 'updated');
        Blade::component('components.card', 'card');
        Blade::component('components.tags', 'tags');

        // dd('Got here');

         view()->composer(['posts.index', 'posts.show'], ActivityComposer::class);
        //   view()->composer(['*'], ActivityComposer::class);

    }
}
