<?php

namespace App\Orders\Filters;


class CityFilter
{
    function __invoke($query, $city_id)
    {
        if (empty($city_id[0]))
            return $query;
            
        return $query->whereIn('city_id', explode(",", $city_id[0]));
    }
}
