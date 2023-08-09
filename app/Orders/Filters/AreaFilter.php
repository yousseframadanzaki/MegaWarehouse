<?php

namespace App\Orders\Filters;


class AreaFilter
{
    function __invoke($query, $area_id)
    {
        return $query->where('area_id',$area_id);
    }
}
