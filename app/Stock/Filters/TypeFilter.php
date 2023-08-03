<?php

namespace App\Stock\Filters;


class TypeFilter
{
    function __invoke($query, $type)
    {
        return $query->where('type',$type);
    }
}
