<?php

namespace App\Accounting\Interfaces;

interface TransactionServiceInterface{
    public function GetInvoiceSum($invoice_id);
    public function AddInvoiceTransaction($transaction_data);
}