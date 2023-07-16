<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\CommonData\Interfaces\CommonDataRepositoryInterface;

use App\CommonData\Services\CommonDataService;
use App\CommonData\Repositories\CommonDataRepository;


class CommonDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CommonDataRepositoryInterface::class,CommonDataRepository::class);
        $this->app->bind(CommonDataServiceInterface::class,CommonDataService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
