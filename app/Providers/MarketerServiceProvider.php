<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Marketers\Interfaces\MarketerCrudServiceInterface;
use App\Marketers\Interfaces\MarketerCrudRepositoryInterface;
use App\Marketers\Services\MarketerCrudService;
use App\Marketers\Repositories\MarketerCrudRepository;

class MarketerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MarketerCrudRepositoryInterface::class,MarketerCrudRepository::class);
        $this->app->bind(MarketerCrudServiceInterface::class,MarketerCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
