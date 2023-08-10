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

use App\Models\Warehouse;
use App\Models\User;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Supplier;

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

    public function get_values() {
        $filters = $this->receivedFilters();
        foreach ($filters as $key => $value) {
            if($key == 'warehouse_id'){
                $filters['warehouse_id'] = Warehouse::findOrfail($value)->name;
                continue;
            }
            if($key == 'admin_id'){
                $filters['admin_id'] = User::findOrfail($value)->name;
                continue;
            }
            if($key == 'product_id'){
                $filters['product_id'] = Product::findOrfail($value)->name;
                continue;
            }
            if($key == 'variant_id'){
                $filters['variant_id'] = Variant::findOrfail($value)->name;
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