<?php

namespace App\Http\Controllers;

use App\ProfitReports\Interfaces\ProfitReportServiceInterface;
use Illuminate\Http\Request;

class ProfitReportController extends Controller
{
    public function __construct(
        protected readonly ProfitReportServiceInterface $ProfitReportService
    )
    {}

    public function get_report_stats() {
        $data = $this->ProfitReportService->GetReportStats();
        return view('Dashboard.ProfitReports.show_one', compact('data'));
    }
}
