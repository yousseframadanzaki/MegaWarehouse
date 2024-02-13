<?php

namespace App\Orders\Filters;


class StatusFilter
{
    function __invoke($query, $status_ids)
    {
        $status_ids = explode(",",$status_ids);
        return $query->whereIn('status_id',$status_ids);
    }
}
