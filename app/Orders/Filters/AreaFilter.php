<?php

namespace App\Orders\Filters;


class AreaFilter
{
    function __invoke($query, $area_id)
    {
        if (empty($area_id[0]))
            return $query;
            
        return $query->where('area_id',explode(",", $area_id[0]));
    }
}
