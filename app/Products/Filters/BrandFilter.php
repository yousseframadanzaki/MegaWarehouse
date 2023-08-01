<?php

namespace App\Products\Filters;


class BrandFilter
{
    function __invoke($query, $brand_id)
    {
        return $query->where('brand_id', $brand_id);
    }
}
