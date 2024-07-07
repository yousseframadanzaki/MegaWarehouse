<?php

namespace App\Products\Filters;


class SkuFilter
{
    function __invoke($query, $sku)
    {
        return $query->whereHas('variants', function($query) use ($sku) {
            $query->where('sku', $sku)->limit(1);
        });
    }
}
