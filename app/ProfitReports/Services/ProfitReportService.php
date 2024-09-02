<?php

namespace App\ProfitReports\Services;

use App\ProfitReports\Interfaces\ProfitReportRepositoryInterface;
use App\ProfitReports\Interfaces\ProfitReportServiceInterface;

class ProfitReportService implements ProfitReportServiceInterface {

    public function __construct(
        protected readonly ProfitReportRepositoryInterface $profit_report_repository
    ) {}

    public function GetReportStats() {
        return $this->profit_report_repository->get_report_stats();
    }
}
