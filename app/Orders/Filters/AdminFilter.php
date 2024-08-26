<?php

namespace App\Orders\Filters;


class AdminFilter
{
    function __invoke($query, $admin_id)
    {
        return $query->where('admin_id',$admin_id);
    }
}
