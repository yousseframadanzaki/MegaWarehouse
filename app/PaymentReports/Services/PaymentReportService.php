<?php

namespace App\PaymentReports\Services;

use App\PaymentReports\Interfaces\PaymentReportRepositoryInterface;
use App\PaymentReports\Interfaces\PaymentReportServiceInterface;

class PaymentReportService implements PaymentReportServiceInterface {

    public function __construct(
        protected readonly PaymentReportRepositoryInterface $payment_report_repository,
    ) {}

    public function GetPaymentReports() {
        return $this->payment_report_repository->get_payment_reports();
    }

    public function GetPaymentReportById($id) {
        return $this->payment_report_repository->get_payment_report_by_id($id);
    }

    public function GetPaymentReportByShippingCompanyId($shipping_company_id) {
        return $this->payment_report_repository->get_payment_report_by_shipping_company_id($shipping_company_id);
    }

    public function CreatePaymentReport(array $data) {
        return $this->payment_report_repository->create_payment_report($data);
    }
}
