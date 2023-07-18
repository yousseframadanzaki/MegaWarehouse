<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\Interfaces\UploadBrandInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Actions\UploadAvatar;
use App\FileUpload\Actions\UploadBrand;
use App\FileUpload\Services\UploadService;

class FileUploadServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UploadAvatarInterface::class,UploadAvatar::class);
        $this->app->bind(UploadBrandInterface::class,UploadBrand::class);
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
