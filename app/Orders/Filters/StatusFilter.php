<?php

namespace App\Orders\Filters;


class StatusFilter
{
    function __invoke($query, $status_id)
    {
        return $query->where('status_id',$status_id);
    }
}
