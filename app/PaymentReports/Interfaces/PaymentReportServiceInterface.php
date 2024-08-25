<?php

namespace App\PaymentReports\Interfaces;

interface PaymentReportServiceInterface{
    public function GetPaymentReports($filters, $request = []);
    public function GetPaymentReportById($id);
    public function GetPaymentReportByShippingCompanyId($shipping_company_id);
    public function CreatePaymentReport(array $data);
}
