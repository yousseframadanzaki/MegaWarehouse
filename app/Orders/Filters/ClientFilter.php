<?php

namespace App\Orders\Filters;


class ClientFilter
{
    function __invoke($query, $client_id)
    {
        return $query->where('client_id',$client_id);
    }
}
