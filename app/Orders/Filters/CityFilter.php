<?php

namespace App\Orders\Filters;


class CityFilter
{
    function __invoke($query, $city_id)
    {
        return $query->whereIn('city_id', explode(",", $city_id[0]));
    }
}
