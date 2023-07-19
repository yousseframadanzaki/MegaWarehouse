<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Clients\Interfaces\ClientCrudServiceInterface;
use App\Clients\Interfaces\ClientCrudRepositoryInterface;

use App\Clients\Services\ClientCrudService;
use App\Clients\Repositories\ClientCrudRepository;

class ClientServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ClientCrudRepositoryInterface::class,ClientCrudRepository::class);
        $this->app->bind(ClientCrudServiceInterface::class,ClientCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
