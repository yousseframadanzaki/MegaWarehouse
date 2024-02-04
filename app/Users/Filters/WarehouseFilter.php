<?php

namespace App\Users\Filters;

class WarehouseFilter
{
    function __invoke($query, $warehouse_id)
    {
        return $query->where('warehouse_id',$warehouse_id);
    }
}