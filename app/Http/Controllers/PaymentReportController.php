<?php

namespace App\Http\Controllers;

use App\PaymentReports\Interfaces\PaymentReportServiceInterface;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\PaymentReports\Filters\PaymentReportFilters;
use Illuminate\Http\Request;

class PaymentReportController extends Controller
{
    public function __construct(
        protected readonly PaymentReportServiceInterface $PaymentReportService,
        protected readonly CommonDataServiceInterface $CommonDataService
    ) {}

    public function all(PaymentReportFilters $filters, Request $request)
    {
        $payment_reports = $this->PaymentReportService->GetPaymentReports($filters, $request->except('_token'));
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        $filters = $filters->get_values();
        return view('Dashboard.ShippingCompanies.reports.show_all')->with(compact('payment_reports', 'shipping_companies', 'filters'));
    }
}
