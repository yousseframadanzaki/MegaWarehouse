<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Services\UploadService;

class FileUploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UploadServiceInterface::class,UploadService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
