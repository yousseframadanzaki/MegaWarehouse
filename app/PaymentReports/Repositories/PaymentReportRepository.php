<?php

namespace App\PaymentReports\Repositories;

use App\Models\PaymentReport;
use App\PaymentReports\Interfaces\PaymentReportRepositoryInterface;

class PaymentReportRepository implements PaymentReportRepositoryInterface {
    public function get_payment_reports($filters, $request) {
        $number = !empty($request['page_orders_num']) ? $request['page_orders_num'] : 50;
        return PaymentReport::with(['shipping_company'])->filter($filters)->orderBy('created_at', 'DESC')->paginate($number)->appends($request);
    }

    public function create_payment_report($data) {
        return PaymentReport::create($data);
    }

    public function get_payment_report_by_id($id) {
        return PaymentReport::with(['transaction', 'image'])->find($id);
    }

    public function get_payment_report_by_shipping_company_id($shipping_company_id) {
        return PaymentReport::where('shipping_company_id', $shipping_company_id)->get();
    }
}
