<?php

namespace App\Invoices\Filters;
use Carbon\Carbon;

class DateFromFilter
{
    function __invoke($query, $date_from)
    {
        $date = Carbon::parse($date_from);
        return $query->where('created_at','>=',$date);
    }
}
