<?php

namespace App\PaymentReports\Interfaces;

interface PaymentReportRepositoryInterface {
    public function get_payment_reports($filters, $request);
    public function get_payment_report_by_id($id);
    public function get_payment_report_by_shipping_company_id($shipping_company_id);
    public function create_payment_report(array $data);
}
