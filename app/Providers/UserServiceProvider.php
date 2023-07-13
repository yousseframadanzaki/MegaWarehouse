<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\Users\Interfaces\UserCrudRepositoryInterface;
use App\Users\Interfaces\UserCrudServiceInterface;
use App\Users\Interfaces\UserActionsServiceInterface;

use App\Users\Repositories\UserCrudRepository;
use App\Users\Services\UserCrudService;
use App\Users\Services\UserActionsService;


class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserCrudRepositoryInterface::class,UserCrudRepository::class);
        $this->app->bind(UserCrudServiceInterface::class,UserCrudService::class);
        $this->app->bind(UserActionsServiceInterface::class,UserActionsService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
