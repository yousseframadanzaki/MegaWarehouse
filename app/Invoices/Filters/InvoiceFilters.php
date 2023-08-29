<?php

namespace App\Invoices\Filters;

use App\Invoices\Filters\DateFromFilter;
use App\Invoices\Filters\DateToFilter;
use App\Invoices\Filters\SupplierFilter;
use App\Invoices\Filters\InvoiceFilter;


use App\Models\Supplier;

class InvoiceFilters
{

    protected $filters = [
        'date_from' => DateFromFilter::class,
        'date_to' => DateToFilter::class,
        'supplier_id' => SupplierFilter::class,
        'invoice_id' => InvoiceFilter::class,
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
        return request()->only(array_keys($this->filters));
    }

    public function get_values() {
        $filters = $this->receivedFilters();
        foreach ($filters as $key => $value) {
            if($key == 'supplier_id'){
                $filters['supplier_id'] = Supplier::findOrfail($value)->name;
                continue;
            }
        }
        return $filters;
    }
}