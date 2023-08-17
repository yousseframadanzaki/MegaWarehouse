<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\ShippingAreas\Interfaces\ShippingAreaRepositoryInterface;
use App\ShippingAreas\Interfaces\ShippingAreaServiceInterface;
use App\ShippingAreas\Repositories\ShippingAreaRepository;
use App\ShippingAreas\Services\ShippingAreaService;

class ShippingAreaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ShippingAreaRepositoryInterface::class,ShippingAreaRepository::class);
        $this->app->bind(ShippingAreaServiceInterface::class,ShippingAreaService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
