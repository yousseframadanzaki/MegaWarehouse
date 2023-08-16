<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\ShippingCompanies\Repositories\ShippingCompanyRepository;
use App\ShippingCompanies\Services\ShippingCompanyService;

class ShippingCompanyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ShippingCompanyRepositoryInterface::class,ShippingCompanyRepository::class);
        $this->app->bind(ShippingCompanyServiceInterface::class,ShippingCompanyService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
