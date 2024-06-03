<?php

namespace App\Accounting\Filters;


class InvoiceFilter
{
    function __invoke($query, $invoice_id)
    {
        return $query->where('invoice_id',$invoice_id);
    }
}
