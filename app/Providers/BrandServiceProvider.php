<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Brands\Interfaces\BrandCrudServiceInterface;
use App\Brands\Interfaces\BrandCrudRepositoryInterface;

use App\Brands\Services\BrandCrudService;
use App\Brands\Repositories\BrandCrudRepository;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(BrandCrudRepositoryInterface::class,BrandCrudRepository::class);
        $this->app->bind(BrandCrudServiceInterface::class,BrandCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
