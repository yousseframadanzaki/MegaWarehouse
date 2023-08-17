<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\ShippingStatus\Interfaces\ShippingStatusRepositoryInterface;
use App\ShippingStatus\Interfaces\ShippingStatusServiceInterface;
use App\ShippingStatus\Repositories\ShippingStatusRepository;
use App\ShippingStatus\Services\ShippingStatusService;

class ShippingStatusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ShippingStatusRepositoryInterface::class,ShippingStatusRepository::class);
        $this->app->bind(ShippingStatusServiceInterface::class,ShippingStatusService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
