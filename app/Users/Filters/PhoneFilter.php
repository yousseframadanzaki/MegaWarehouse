<?php

namespace App\Users\Filters;

class PhoneFilter
{
    function __invoke($query, $phone)
    {
        return $query->where('phone_1',$phone);
    }
}