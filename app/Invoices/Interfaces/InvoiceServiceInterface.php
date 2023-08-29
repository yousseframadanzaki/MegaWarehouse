<?php

namespace App\Invoices\Interfaces;

interface InvoiceServiceInterface{
    public function AddInvoice($invoice_info);
    public function GetCompanyInvoices($company_id,$filters);
    public function GetInvoice($invoice_id);
}