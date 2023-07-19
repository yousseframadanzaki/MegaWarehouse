<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Suppliers\Interfaces\SupplierCrudRepositoryInterface;
use App\Suppliers\Interfaces\SupplierCrudServiceInterface;

use App\Suppliers\Repositories\SupplierCrudRepository;
use App\Suppliers\Services\SupplierCrudService;

class SupplierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SupplierCrudRepositoryInterface::class,SupplierCrudRepository::class);
        $this->app->bind(SupplierCrudServiceInterface::class,SupplierCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
