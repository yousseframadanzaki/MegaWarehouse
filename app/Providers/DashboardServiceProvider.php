<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Dashboard\Interfaces\DashboardRepositoryInterface;
use App\Dashboard\Repositories\DashboardRepository;

use App\Dashboard\Interfaces\DashboardServiceInterface;
use App\Dashboard\Services\DashboardService;

class DashboardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(DashboardRepositoryInterface::class,DashboardRepository::class);
        $this->app->bind(DashboardServiceInterface::class,DashboardService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
