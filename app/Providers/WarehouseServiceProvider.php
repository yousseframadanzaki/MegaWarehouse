<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Warehouses\Interfaces\WarehouseCrudRepositoryInterface;
use App\Warehouses\Interfaces\WarehouseCrudServiceInterface;

use App\Warehouses\Repositories\WarehouseCrudRepository;
use App\Warehouses\Services\WarehouseCrudService;

class WarehouseServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(WarehouseCrudRepositoryInterface::class,WarehouseCrudRepository::class);
        $this->app->bind(WarehouseCrudServiceInterface::class,WarehouseCrudService::class);
    }

    public function boot(): void
    {
        
    }
}
