<?php

namespace App\PaymentReports\Filters;

use App\Models\ShippingCompany;
use App\PaymentReports\Filters\DateFromFilter;
use App\PaymentReports\Filters\DateToFilter;
use App\PaymentReports\Filters\ShippingCompanyFilter;

class PaymentReportFilters
{

    protected $filters = [
        'shipping_company_id' => ShippingCompanyFilter::class,
        'date_from' => DateFromFilter::class,
        'date_to' => DateToFilter::class,
    ];

    public function apply($query)
    {
        foreach ($this->receivedFilters() as $name => $value) {
            $filterInstance = new $this->filters[$name];
            $query = $filterInstance($query, $value);
        }
        return $query;
    }

    public function receivedFilters()
    {
        $filters = request()->only(array_keys($this->filters));
        $filtered = array_filter($filters, function($value) {
            return !is_null($value);
        });
        return $filtered;
    }

    public function get_values() {
        $filters = $this->receivedFilters();
        foreach ($filters as $key => $value) {
            if($key == 'shipping_company_id'){
                $filters['shipping_company_id'] = ShippingCompany::findOrfail($value)->name;
                continue;
            }
        }
        return $filters;
    }
}
