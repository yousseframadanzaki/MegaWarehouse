<?php

namespace App\Invoices\Repositories;

use App\Invoices\Interfaces\InvoiceRepositoryInterface;

use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface{
    
    public function create_invoice(array $details){
        $invoice = Invoice::create($details);
        return $invoice->id;
    }
}