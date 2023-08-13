<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Cart\Interfaces\CartServiceInterface;
use App\Cart\Interfaces\CartRepositoryInterface;

use App\Cart\Repositories\CartRepository;
use App\Cart\Services\CartService;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CartRepositoryInterface::class,CartRepository::class);
        $this->app->bind(CartServiceInterface::class,CartService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
