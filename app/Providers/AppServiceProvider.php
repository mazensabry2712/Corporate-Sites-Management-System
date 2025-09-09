<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Helper function لعرض الصور من مجلد storge
        if (!function_exists('storge_asset')) {
            function storge_asset($path) {
                return url('storge/' . ltrim($path, '/'));
            }
        }
    }






}
