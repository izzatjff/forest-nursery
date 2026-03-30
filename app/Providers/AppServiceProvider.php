<?php

namespace App\Providers;

use App\Services\InventoryService;
use App\Services\PricingEngine;
use App\Services\QrCodeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PricingEngine::class);
        $this->app->singleton(QrCodeService::class);
        $this->app->singleton(InventoryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
