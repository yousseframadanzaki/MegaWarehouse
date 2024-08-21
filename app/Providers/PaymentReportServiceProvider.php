<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\PaymentReports\Interfaces\PaymentReportRepositoryInterface;
use App\PaymentReports\Interfaces\PaymentReportServiceInterface;
use App\PaymentReports\Repositories\PaymentReportRepository;
use App\PaymentReports\Services\PaymentReportService;

class PaymentReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentReportRepositoryInterface::class,PaymentReportRepository::class);
        $this->app->bind(PaymentReportServiceInterface::class,PaymentReportService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
