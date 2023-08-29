<?php

namespace App\Stock\Filters;


class InvoiceFilter
{
    function __invoke($query, $invoice_id)
    {
        return $query->where('invoice_id',$invoice_id);
    }
}
