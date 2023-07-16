<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Roles\Interfaces\RoleCrudRepositoryInterface;
use App\Roles\Interfaces\RoleCrudServiceInterface;

use App\Roles\Repositories\RoleCrudRepository;
use App\Roles\Services\RoleCrudService;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RoleCrudRepositoryInterface::class,RoleCrudRepository::class);
        $this->app->bind(RoleCrudServiceInterface::class,RoleCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
