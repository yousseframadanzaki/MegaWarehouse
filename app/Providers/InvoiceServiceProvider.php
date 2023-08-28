<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Invoices\Interfaces\InvoiceServiceInterface;
use App\Invoices\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Services\InvoiceService;
use App\Invoices\Repositories\InvoiceRepository;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InvoiceRepositoryInterface::class,InvoiceRepository::class);
        $this->app->bind(InvoiceServiceInterface::class,InvoiceService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
