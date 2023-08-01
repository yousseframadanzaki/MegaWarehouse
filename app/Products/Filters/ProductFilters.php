<?php

namespace App\Products\Filters;

use App\Products\Filters\CategoryFilter;
use App\Products\Filters\BrandFilter;
use App\Products\Filters\NameFilter;
use App\Products\Filters\SupplierFilter;

class ProductFilters
{

    protected $filters = [
        'category_id' => CategoryFilter::class,
        'brand_id' => BrandFilter::class,
        'name' => NameFilter::class,
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