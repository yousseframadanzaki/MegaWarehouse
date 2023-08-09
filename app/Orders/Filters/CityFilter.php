<?php

namespace App\Orders\Filters;


class CityFilter
{
    function __invoke($query, $city_id)
    {
        return $query->where('city_id',$city_id);
    }
}
