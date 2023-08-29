<?php

namespace App\Invoices\Filters;


class InvoiceFilter
{
    function __invoke($query, $invoice_id)
    {
        return $query->where('id', $invoice_id);
    }
}
