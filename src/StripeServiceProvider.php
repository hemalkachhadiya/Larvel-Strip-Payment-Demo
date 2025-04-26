<?php

namespace Smarttech\StripePayment;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StripeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $count = 0;

            if (Auth::check()) {
                $userId = auth()->user()->id;
                $count = DB::table('cart_items')->where('user_id', $userId)->count();
            }
            $view->with('cartItemCount', $count);
        });
        // $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        // $this->loadViewsFrom(__DIR__.'/resources/views', 'stripe');
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'cartstripe');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([
            __DIR__.'/config/cartstripe.php' => config_path('cartstripe.php'),
        ], 'config');

        \Illuminate\Support\Facades\Blade::component('cartstripe::components.order-display', 'order-display');

    }

    public function register()
    {
        //
    }
}
