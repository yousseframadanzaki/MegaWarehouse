<?php

namespace App\PaymentReports\Services;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;
use App\PaymentReports\Interfaces\PaymentReportRepositoryInterface;
use App\PaymentReports\Interfaces\PaymentReportServiceInterface;

class PaymentReportService implements PaymentReportServiceInterface {

    public function __construct(
        protected readonly PaymentReportRepositoryInterface $payment_report_repository,
        protected readonly OrdersRepositoryInterface $OrdersRepository,
        protected readonly TransactionServiceInterface $TransactionService,
        protected readonly UploadServiceInterface $FileUploadService,
        protected readonly MediaCrudServiceInterface $MediaCrudService,
        protected readonly ShippingCompanyServiceInterface $ShippingCompanyService
    ) {}

    public function GetPaymentReports($filters, $request = []) {
        return $this->payment_report_repository->get_payment_reports($filters, $request);
    }

    public function GetPaymentReportById($id) {
        return $this->payment_report_repository->get_payment_report_by_id($id);
    }

    public function GetPaymentReportByShippingCompanyId($shipping_company_id) {
        return $this->payment_report_repository->get_payment_report_by_shipping_company_id($shipping_company_id);
    }

    public function CreatePaymentReport($data)
    {
        $auth_user = auth()->user();

        // create payment report
        $payment_report_data = $data['payment_report'];
        $payment_report = $this->payment_report_repository->create_payment_report($payment_report_data);

        if($payment_report) {
            // update orders
            $this->OrdersRepository->update_orders(explode("\n", $data['order_ids']), ['payment_report_id' => $payment_report->id]);
            // add transaction
            $transaction_data = [
                'from' => $this->ShippingCompanyService->GetShippingCompany($payment_report_data['shipping_company_id'])->user_id,
                'to' => $data['user_id'],
                'value' => ($payment_report_data['total_cod'] - $payment_report_data['total_shipping_cost']),
                'payment_type_id' => 9,
                'payment_report_id' => $payment_report->id,
                'company_id' => $auth_user->company_id,
                'admin_id' => $auth_user->id,
                'note' => $payment_report_data['note']
            ];
            $this->TransactionService->AddTransaction($transaction_data);
            // add image
            $image = $this->FileUploadService->handle($data['image'], 'payment_reports',$auth_user->company_id,$payment_report->id);
            $this->MediaCrudService->save($image);

            return $payment_report->id;
        }
        return false;
    }
}
