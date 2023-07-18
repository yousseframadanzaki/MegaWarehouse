<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Categories\Interfaces\CategoryCrudServiceInterface;
use App\Categories\Interfaces\CategoryCrudRepositoryInterface;

use App\Categories\Services\CategoryCrudService;
use App\Categories\Repositories\CategoryCrudRepository;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryCrudRepositoryInterface::class,CategoryCrudRepository::class);
        $this->app->bind(CategoryCrudServiceInterface::class,CategoryCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
