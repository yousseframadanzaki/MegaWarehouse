<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Authentication\Interfaces\LoginRepositoryInterface;
use App\Authentication\Interfaces\LoginServiceInterface;
use App\Authentication\Services\LoginService;
use App\Authentication\Repositories\LoginRepository;

class AuthenticationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
       $this->app->bind(LoginRepositoryInterface::class,LoginRepository::class);
       $this->app->bind(LoginServiceInterface::class,LoginService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
