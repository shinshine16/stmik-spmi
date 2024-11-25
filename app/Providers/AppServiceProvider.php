<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Config;

use Illuminate\Support\ServiceProvider;

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
        // Share the $config variable with all views
        View::composer('*', function ($view) {
            $config = Config::find(1); // Ambil konfigurasi dari database
            $view->with('config', $config);
        });
    }
}
