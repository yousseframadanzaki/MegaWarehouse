<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Orders\Interfaces\OrdersServiceInterface;

use App\Orders\Repositories\OrdersRepository;
use App\Orders\Services\OrdersService;

class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(OrdersRepositoryInterface::class,OrdersRepository::class);
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
