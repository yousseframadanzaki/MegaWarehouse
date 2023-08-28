<?php

namespace App\Invoices\Interfaces;

interface InvoiceRepositoryInterface{
    public function create_invoice(array $details);
}