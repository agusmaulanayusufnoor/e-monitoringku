<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;  
use Filament\Support\Facades\FilamentAsset;  
use Filament\Support\Assets\Js;  

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        FilamentAsset::register([
            Js::make('custom-script', __DIR__ . '/../../resources/js/custom.js')->loadedOnRequest(),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
