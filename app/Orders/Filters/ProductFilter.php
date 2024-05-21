<?php

namespace App\Orders\Filters;


class ProductFilter
{
    function __invoke($query, $product_id)
    {
        return $query->whereHas('stocks.variant.product', function ($query) use ($product_id) {
            $query->where('id', $product_id);
        });
    }
}
