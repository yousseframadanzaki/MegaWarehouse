<?php

namespace App\Accounting\Interfaces;

interface TransactionServiceInterface{
    public function GetInvoiceSum($invoice_id);
    public function AddInvoiceTransaction($transaction_data);
    public function GetCompanyTransactions($company_id, $filters);
    public function AddTransaction($transaction_data);
}
