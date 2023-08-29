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

    public function GetCompanyInvoices($company_id,$filters){
        return $this->invoice_repository->get_invoices_by_company_id($company_id,$filters);
    }

    public function GetInvoice($invoice_id){
        return $this->invoice_repository->get_invoice_by_id($invoice_id);
    }
 
}