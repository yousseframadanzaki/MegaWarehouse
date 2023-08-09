<?php

namespace App\Orders\Filters;


class OrderCodeFilter
{
    function __invoke($query, $order_code)
    {
        return $query->where('order_code',$order_code);
    }
}
