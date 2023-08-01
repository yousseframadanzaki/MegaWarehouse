<?php

namespace App\Products\Filters;


class SupplierFilter
{
    function __invoke($query, $supplier_id)
    {
        return $query->where('supplier_id', $supplier_id);
    }
}
