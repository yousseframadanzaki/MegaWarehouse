<?php

namespace App\PaymentReports\Filters;


class ShippingCompanyFilter
{
    function __invoke($query, $shipping_company_id)
    {
        return $query->where('shipping_company_id', $shipping_company_id);
    }
}
