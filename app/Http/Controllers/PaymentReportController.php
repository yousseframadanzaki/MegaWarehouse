<?php

namespace App\Http\Controllers;

use App\PaymentReports\Interfaces\PaymentReportServiceInterface;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\PaymentReports\Filters\PaymentReportFilters;
use Illuminate\Http\Request;

class PaymentReportController extends Controller
{
    public function __construct(
        protected readonly PaymentReportServiceInterface $PaymentReportService,
        protected readonly CommonDataServiceInterface $CommonDataService,
        protected readonly ShippingCompanyServiceInterface $ShippingCompanyService,
    ) {}

    public function all(PaymentReportFilters $filters, Request $request)
    {
        $payment_reports = $this->PaymentReportService->GetPaymentReports($filters, $request->except('_token'));
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        $filters = $filters->get_values();
        return view('Dashboard.ShippingCompanies.reports.show_all')->with(compact('payment_reports', 'shipping_companies', 'filters'));
    }

    public function create() {
        $shipping_companies = $this->ShippingCompanyService->GetCompanyShippingCompanies($this->company_id());
        $users = $this->CommonDataService->GetUsersByRoleType($this->company_id(), 1)->pluck('name', 'id');
        return view('Dashboard.ShippingCompanies.Reports.add')->with(compact('shipping_companies', 'users'));
    }

    public function store(Request $request) {
        $report_id = $this->PaymentReportService->CreatePaymentReport($request->except('_token'));
        if (!empty($report_id))
            return redirect()->back()->with('success', 'تم إضافة التقرير بنجاح');
        return redirect()->back()->with('error', 'خطأ في إضافة التقرير');
    }

    public function show($id) {
        $payment_report = $this->PaymentReportService->GetPaymentReportById($id);
        return view('Dashboard.ShippingCompanies.Reports.show_one', compact('payment_report'));
    }
}
