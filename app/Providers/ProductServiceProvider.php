<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\Products\Interfaces\ProductCrudRepositoryInterface;
use App\Products\Interfaces\ProductCrudServiceInterface;
use App\Products\Interfaces\ProductAttributesRepositoryInterface;
use App\Products\Interfaces\ProductVariantsRepositoryInterface;
use App\Products\Interfaces\VariantStockServiceInterface;
use App\Products\Interfaces\ProductPackageRepositoryInterface;

use App\Products\Repositories\ProductAttributesRepository;
use App\Products\Repositories\ProductVariantsRepository;
use App\Products\Repositories\ProductCrudRepository;
use App\Products\Repositories\ProductPackageRepository;
use App\Products\Services\ProductCrudService;
use App\Products\Services\VariantStockService;


class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductAttributesRepositoryInterface::class,ProductAttributesRepository::class);
        $this->app->bind(ProductVariantsRepositoryInterface::class,ProductVariantsRepository::class);
        $this->app->bind(ProductCrudRepositoryInterface::class,ProductCrudRepository::class);
        $this->app->bind(ProductCrudServiceInterface::class,ProductCrudService::class);
        $this->app->bind(VariantStockServiceInterface::class,VariantStockService::class);
        $this->app->bind(ProductPackageRepositoryInterface::class,ProductPackageRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
