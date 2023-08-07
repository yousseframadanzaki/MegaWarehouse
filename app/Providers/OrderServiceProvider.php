<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Orders\Interfaces\OrdersRepsoitoryInterface;
use App\Orders\Interfaces\OrdersServiceInterface;

use App\Orders\Repositories\OrdersRepsoitory;
use App\Orders\Services\OrdersService;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrdersRepsoitoryInterface::class,OrdersRepsoitory::class);
        $this->app->bind(OrdersServiceInterface::class,OrdersService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
