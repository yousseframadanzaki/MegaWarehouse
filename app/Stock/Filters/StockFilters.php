<?php

namespace App\Stock\Filters;

use App\Stock\Filters\WarehouseFilter;
use App\Stock\Filters\AdminFilter;
use App\Stock\Filters\ProductFilter;
use App\Stock\Filters\DateFromFilter;
use App\Stock\Filters\DateToFilter;
use App\Stock\Filters\TypeFilter;
use App\Stock\Filters\VariantFilter;
use App\Stock\Filters\SupplierFilter;

class StockFilters
{

    protected $filters = [
        'warehouse_id' => WarehouseFilter::class,
        'admin_id' => AdminFilter::class,
        'product_id' => ProductFilter::class,
        'variant_id' => VariantFilter::class,
        'date_from' => DateFromFilter::class,
        'date_to' => DateToFilter::class,
        'type' => TypeFilter::class,
        'supplier_id' => SupplierFilter::class,
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

}