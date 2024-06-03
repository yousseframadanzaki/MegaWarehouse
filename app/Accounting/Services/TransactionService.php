<?php

namespace App\Accounting\Services;

use App\Accounting\Interfaces\TransactionServiceInterface;
use App\Accounting\Interfaces\TransactionRepositoryInterface;


enum Type: string
{
    case SUPPLIER_INVOICE = '4';
}


class TransactionService implements TransactionServiceInterface{

    public function __construct(
        protected readonly TransactionRepositoryInterface $transaction_repository
    ) {}

    public function GetInvoiceSum($invoice_id){
        return $this->transaction_repository->get_sum_by_invoice_id($invoice_id);
    }

    public function AddInvoiceTransaction($transaction_data){
        $transaction_data['payment_type_id'] = Type::SUPPLIER_INVOICE;
        return $this->transaction_repository->create_transaction($transaction_data);
    }

    public function AddTransaction($transaction_data){
        return $this->transaction_repository->create_transaction($transaction_data);
    }

    public function GetCompanyTransactions($company_id, $filters){
        return $this->transaction_repository->get_transactions_by_company_id($company_id, $filters);
    }

}
