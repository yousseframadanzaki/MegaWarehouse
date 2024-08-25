<?php

namespace App\PaymentReports\Filters;
use Carbon\Carbon;

class DateToFilter
{
    function __invoke($query, $date_to)
    {
        $date = Carbon::parse($date_to);
        return $query->where('created_at','<=',$date);
    }
}
