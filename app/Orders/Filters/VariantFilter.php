<?php

namespace App\Orders\Filters;


class VariantFilter
{
    function __invoke($query, $variant_id)
    {
        return $query->whereHas('stocks.variant', function ($query) use ($variant_id) {
            $query->where('id', $variant_id);
        });
    }
}
