<?php

namespace App\Accounting\Filters;


class FromUserFilter
{
    function __invoke($query, $from_user)
    {
        return $query->where('from', $from_user);
    }
}
