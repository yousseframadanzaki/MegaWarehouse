<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Status\Interfaces\StatusServiceInterface;
use App\Status\Interfaces\StatusRepositoryInterface;
use App\Status\Repositories\StatusRepository;
use App\Status\Services\StatusService;

class StatusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StatusRepositoryInterface::class,StatusRepository::class);
        $this->app->bind(StatusServiceInterface::class,StatusService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
