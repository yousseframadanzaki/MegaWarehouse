<?php

namespace App\PaymentReports\Repositories;

use App\Models\PaymentReport;
use App\PaymentReports\Interfaces\PaymentReportRepositoryInterface;

class PaymentReportRepository implements PaymentReportRepositoryInterface {
    public function get_payment_reports() {
        return PaymentReport::all();
    }

    public function create_payment_report($data) {
        return PaymentReport::create($data);
    }

    public function get_payment_report_by_id($id) {
        return PaymentReport::find($id);
    }

    public function get_payment_report_by_shipping_company_id($shipping_company_id) {
        return PaymentReport::where('shipping_company_id', $shipping_company_id)->get();
    }
}
