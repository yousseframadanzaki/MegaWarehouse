<?php

namespace App\Products\Filters;

use App\Products\Filters\CategoryFilter;
use App\Products\Filters\BrandFilter;
use App\Products\Filters\NameFilter;
use App\Products\Filters\SupplierFilter;
use App\Products\Filters\SkuFilter;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Supplier;

class ProductFilters
{

    protected $filters = [
        'category_id' => CategoryFilter::class,
        'brand_id' => BrandFilter::class,
        'product_name' => NameFilter::class,
        'supplier_id' => SupplierFilter::class,
        'sku' => SkuFilter::class,
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
            if($key == 'category_id'){
                $filters['category_id'] = Category::findOrfail($value)->name;
                continue;
            }
            if($key == 'brand_id'){
                $filters['brand_id'] = Brand::findOrfail($value)->name;
                continue;
            }
            if($key == 'supplier_id'){
                $filters['supplier_id'] = Supplier::findOrfail($value)->name;
                continue;
            }
        }
        return $filters;
    }
}
