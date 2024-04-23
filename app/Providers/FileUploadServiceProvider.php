<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\FileUpload\Interfaces\UploadAvatarInterface;
use App\FileUpload\Interfaces\UploadBrandInterface;
use App\FileUpload\Interfaces\UploadProductInterface;
use App\FileUpload\Interfaces\UploadProductMainInterface;
use App\FileUpload\Interfaces\UploadStockInterface;
use App\FileUpload\Interfaces\UploadTransactionInterface;
use App\FileUpload\Interfaces\UploadStatusInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\FileUpload\Interfaces\UploadVarientInterface;
use App\FileUpload\Actions\UploadAvatar;
use App\FileUpload\Actions\UploadBrand;
use App\FileUpload\Actions\UploadProduct;
use App\FileUpload\Actions\UploadProductMain;
use App\FileUpload\Actions\UploadStock;
use App\FileUpload\Actions\UploadTransaction;
use App\FileUpload\Actions\UploadStatus;
use App\FileUpload\Actions\UploadVarient;
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
        $this->app->bind(UploadProductInterface::class,UploadProduct::class);
        $this->app->bind(UploadProductMainInterface::class,UploadProductMain::class);
        $this->app->bind(UploadStockInterface::class,UploadStock::class);
        $this->app->bind(UploadStatusInterface::class,UploadStatus::class);
        $this->app->bind(UploadServiceInterface::class,UploadService::class);
        $this->app->bind(UploadTransactionInterface::class,UploadTransaction::class);
        $this->app->bind(UploadVarientInterface::class,UploadVarient::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
