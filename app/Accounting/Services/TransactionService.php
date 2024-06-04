<?php

namespace App\Accounting\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;
use App\Accounting\Interfaces\TransactionRepositoryInterface;
use App\Models\Transaction;

enum Type: string
{
    case SUPPLIER_INVOICE = '4';
}


class TransactionService implements TransactionServiceInterface{

    public function __construct(
        protected readonly TransactionRepositoryInterface $transaction_repository,
        protected readonly  UploadServiceInterface $FileUploadService,
        protected readonly  MediaCrudServiceInterface $MediaService,
    ) {}

    public function GetInvoiceSum($invoice_id){
        return $this->transaction_repository->get_sum_by_invoice_id($invoice_id);
    }

    public function AddInvoiceTransaction($transaction_data){
        $transaction_data['payment_type_id'] = Type::SUPPLIER_INVOICE;
        return $this->transaction_repository->create_transaction($transaction_data);
    }

    public function AddTransaction($transaction_data){
        $transaction = $this->transaction_repository->create_transaction($transaction_data);
        if (!empty($transaction_data['images'])) {
            $this->add_images($transaction, $transaction_data['images']);
        }
    }

    public function GetCompanyTransactions($company_id, $filters){
        return $this->transaction_repository->get_transactions_by_company_id($company_id, $filters);
    }

    private function add_images($transaction, $images)
    {
        foreach ($images as $image) {
            $file = $this->FileUploadService->transaction($image, $transaction->company_id, $transaction->id);
            $this->MediaService->save($file);
        }
    }
}
