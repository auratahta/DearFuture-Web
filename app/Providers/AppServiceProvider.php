<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap any application services.
     */
    // public function boot(): void
    // {
        // Share $user variable with all views
//         View::composer('*', function ($view) {
//             if (Auth::check()) {
//                 $view->with('user', Auth::user());
//             }
//         });
//     }
}