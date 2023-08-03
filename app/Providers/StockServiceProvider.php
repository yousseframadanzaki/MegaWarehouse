<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Stock\Interfaces\StockOperationRepositoryInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Stock\Repositories\StockOperationRepository;
use App\Stock\Services\StockOperationService;

class StockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StockOperationRepositoryInterface::class,StockOperationRepository::class);
        $this->app->bind(StockOperationServiceInterface::class,StockOperationService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
