<?php

namespace App\Stock\Filters;


class VariantFilter
{
    function __invoke($query, $variant_id)
    {
        return $query->where('variant_id',$variant_id);
    }
}
