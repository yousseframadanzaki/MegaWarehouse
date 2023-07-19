<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Clients\Interfaces\ClientCrudServiceInterface;
use App\Clients\Interfaces\ClientCrudRepositoryInterface;
use App\Clients\Interfaces\ClientGroupCrudServiceInterface;
use App\Clients\Interfaces\ClientGroupCrudRepositoryInterface;

use App\Clients\Services\ClientCrudService;
use App\Clients\Repositories\ClientCrudRepository;
use App\Clients\Services\ClientGroupCrudService;
use App\Clients\Repositories\ClientGroupCrudRepository;

class ClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ClientCrudRepositoryInterface::class,ClientCrudRepository::class);
        $this->app->bind(ClientCrudServiceInterface::class,ClientCrudService::class);
        $this->app->bind(ClientGroupCrudRepositoryInterface::class,ClientGroupCrudRepository::class);
        $this->app->bind(ClientGroupCrudServiceInterface::class,ClientGroupCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
