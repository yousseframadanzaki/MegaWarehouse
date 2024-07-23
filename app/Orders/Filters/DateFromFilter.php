<?php

namespace App\Orders\Filters;
use Carbon\Carbon;

class DateFromFilter
{
    function __invoke($query, $date_from)
    {
        $date_arr = explode("|", $date_from);
        $date_from = $date_arr[0];
        $date_type = $date_arr[1];
        $date = Carbon::parse($date_from);
        if ($date_type == 'الاوردرات')
            return $query->where('created_at','>=',$date);
        else if ($date_type == 'الحالات')
            return $query->whereHas('order_status', function($query) use ($date) {
                $query->where('order_status.created_at','>=',$date);
            });
    }
}
