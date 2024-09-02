<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\ProfitReports\Interfaces\ProfitReportRepositoryInterface;
use App\ProfitReports\Interfaces\ProfitReportServiceInterface;
use App\ProfitReports\Repositories\ProfitReportRepository;
use App\ProfitReports\Services\ProfitReportService;

class ProfitReportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProfitReportRepositoryInterface::class,ProfitReportRepository::class);
        $this->app->bind(ProfitReportServiceInterface::class,ProfitReportService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
