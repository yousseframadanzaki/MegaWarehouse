<?php

namespace App\Accounting\Filters;


class OrderCodeFilter
{
    function __invoke($query, $order_id)
    {
        return $query->where('order_id',$order_id);
    }
}
