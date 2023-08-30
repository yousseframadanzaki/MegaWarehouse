<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Accounting\Interfaces\TransactionRepositoryInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;
use App\Accounting\Repositories\TransactionRepository;
use App\Accounting\Services\TransactionService;

class AccountingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(TransactionRepositoryInterface::class,TransactionRepository::class);
        $this->app->bind(TransactionServiceInterface::class,TransactionService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
