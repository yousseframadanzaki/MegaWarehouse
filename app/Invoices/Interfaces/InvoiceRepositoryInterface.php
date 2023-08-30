<?php

namespace App\Invoices\Interfaces;

interface InvoiceRepositoryInterface{
    public function create_invoice(array $details);
    public function get_invoices_by_company_id($company_id,$filters);
    public function get_invoice_by_id($invoice_id);
    public function get_invoice_no_relations($invoice_id);
}