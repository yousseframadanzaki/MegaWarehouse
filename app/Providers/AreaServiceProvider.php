<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Area\Interfaces\AreaRepositoryInterface;
use App\Area\Interfaces\AreaServiceInterface;
use App\Area\Repositories\AreaRepository;
use App\Area\Services\AreaService;

class AreaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AreaRepositoryInterface::class,AreaRepository::class);
        $this->app->bind(AreaServiceInterface::class,AreaService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
