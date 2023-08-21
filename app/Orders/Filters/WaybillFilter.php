<?php

namespace App\Orders\Filters;


class WaybillFilter
{
    function __invoke($query, $waybill)
    {
        return $query->where('waybill',$waybill);
    }
}
