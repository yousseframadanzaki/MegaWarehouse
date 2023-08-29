<?php

namespace App\Invoices\Repositories;

use App\Invoices\Interfaces\InvoiceRepositoryInterface;

use App\Models\Invoice;

class InvoiceRepository implements InvoiceRepositoryInterface{
    
    public function create_invoice(array $details){
        $invoice = Invoice::create($details);
        return $invoice->id;
    }
    
    public function get_invoices_by_company_id($company_id,$filters){
        return Invoice::with([
            'supplier',
        ])->where(['company_id'=>$company_id])
        ->filter($filters)
        ->orderBy('created_at','DESC')
        ->paginate(20);
    }
    public function get_invoice_by_id($invoice_id){
        return Invoice::with([
            'stocks',
            'stocks.admin',
            'stocks.warehouse',
            'stocks.variant',
            'stocks.variant.product',
            'supplier',
        ])->where(['id'=>$invoice_id])->first();
    }
}