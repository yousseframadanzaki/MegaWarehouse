<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Companies\Interfaces\CompanyCrudRepositoryInterface;
use App\Companies\Interfaces\CompanyCrudServiceInterface;
use App\Companies\Interfaces\CompanyActionsServiceInterface;

use App\Companies\Services\CompanyCrudService;
use App\Companies\Services\CompanyActionsService;
use App\Companies\Repositories\CompanyCrudRepository;

class CompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CompanyCrudRepositoryInterface::class,CompanyCrudRepository::class);
        $this->app->bind(CompanyCrudServiceInterface::class,CompanyCrudService::class);
        $this->app->bind(CompanyActionsServiceInterface::class,CompanyActionsService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
