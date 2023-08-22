<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Templates\Interfaces\TemplateRepositoryInterface;
use App\Templates\Interfaces\TemplateServiceInterface;

use App\Templates\Repositories\TemplateRepository;
use App\Templates\Services\TemplateService;

class TemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TemplateRepositoryInterface::class,TemplateRepository::class);
        $this->app->bind(TemplateServiceInterface::class,TemplateService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
