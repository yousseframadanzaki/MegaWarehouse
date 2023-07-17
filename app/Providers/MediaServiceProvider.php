<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Media\Interfaces\MediaCrudRepositoryInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;
use App\Media\Repositories\MediaCrudRepository;
use App\Media\Services\MediaCrudService;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(MediaCrudRepositoryInterface::class,MediaCrudRepository::class);
        $this->app->bind(MediaCrudServiceInterface::class,MediaCrudService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
