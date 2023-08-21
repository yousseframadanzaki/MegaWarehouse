<?php

namespace App\Orders\Filters;


class MarketerFilter
{
    function __invoke($query, $marketer_id)
    {
        return $query->where('marketer_id',$marketer_id);
    }
}
