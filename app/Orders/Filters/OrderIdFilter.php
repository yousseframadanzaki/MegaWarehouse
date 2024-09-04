<?php

namespace App\Orders\Filters;


class OrderIdFilter
{
    function __invoke($query, $order_ids)
    {
        return $query->whereIn('id', explode(',', $order_ids));
    }
}
