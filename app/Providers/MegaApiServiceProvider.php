<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\MegaAPI\Interfaces\MegaApiRepositoryInterface;
use App\MegaAPI\Interfaces\MegaApiServiceInterface;
use App\MegaAPI\Repositories\MegaApiRepository;
use App\MegaAPI\Services\MegaApiService;

class MegaApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MegaApiRepositoryInterface::class,MegaApiRepository::class);
        $this->app->bind(MegaApiServiceInterface::class,MegaApiService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
