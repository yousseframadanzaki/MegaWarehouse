<?php

namespace App\Accounting\Filters;


class PaymentTypeFilter
{
    function __invoke($query, $payment_type_id)
    {
        return $query->where('payment_type_id',$payment_type_id);
    }
}
