<?php

namespace App\Invoices\Filters;


class SupplierFilter
{
    function __invoke($query, $supplier_id)
    {
        return $query->where('supplier_id', $supplier_id);
    }
}
