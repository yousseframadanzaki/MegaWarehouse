<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Companies\Interfaces\CompanyCrudRepositoryInterface;
use App\Companies\Interfaces\CompanyCrudServiceInterface;

use App\Companies\Services\CompanyCrudService;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
