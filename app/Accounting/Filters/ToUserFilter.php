<?php

namespace App\Accounting\Filters;


class ToUserFilter
{
    function __invoke($query, $to_user)
    {
        return $query->where('to', $to_user);
    }
}
