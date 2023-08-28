<?php

namespace App\Invoices\Services;

use App\Invoices\Interfaces\InvoiceRepositoryInterface;
use App\Invoices\Interfaces\InvoiceServiceInterface;

class InvoiceService implements InvoiceServiceInterface{

    public function __construct(
       protected readonly InvoiceRepositoryInterface $invoice_repository
    ) {}

    public function AddInvoice($invoice_info){
        return $this->invoice_repository->create_invoice($invoice_info);
    }
    
}