<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        Schema::defaultStringLength(191);

        // This for HTTPS CERTIFICATES
        if(env('FORCE_HTTPS',true)) {
            URL::forceScheme('https');
        }

        if (app()->environment('remote')) {
            URL::forceSchema('https');
        }
    }
}
