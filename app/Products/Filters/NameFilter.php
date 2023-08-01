<?php

namespace App\Products\Filters;


class NameFilter
{
    function __invoke($query, $name)
    {
        return $query->where('name','LIKE',"%$name%");
    }
}
