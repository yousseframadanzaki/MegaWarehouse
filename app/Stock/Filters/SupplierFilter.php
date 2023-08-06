<?php

namespace App\Stock\Filters;


class SupplierFilter
{
    function __invoke($query, $supplier_id)
    {
        return $query->whereHas('variant.product.supplier', function ($query) use ($supplier_id) {
            $query->where('id', $supplier_id);
        });
    }
}
