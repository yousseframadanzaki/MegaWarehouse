<?php

namespace App\Orders\Filters;
use Carbon\Carbon;

class DateToFilter
{
    function __invoke($query, $date_to)
    {
        $date_arr = explode("|", $date_to);
        $date_to = $date_arr[0];
        $date_type = $date_arr[1];
        $date = Carbon::parse($date_to);
        if ($date_type == 'الاوردرات')
            return $query->where('created_at', '<=', $date);
        else if ($date_type == 'الحالات')
            return $query->whereHas('order_status', function($query) use ($date) {
                $query->where('order_status.created_at', '<=', $date);
            });
    }
}
