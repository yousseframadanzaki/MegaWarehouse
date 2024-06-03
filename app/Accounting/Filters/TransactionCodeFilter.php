<?php

namespace App\Accounting\Filters;


class TransactionCodeFilter
{
    function __invoke($query, $transaction_code)
    {
        return $query->where('id',$transaction_code);
    }
}
