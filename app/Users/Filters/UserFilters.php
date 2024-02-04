<?php

namespace App\Users\Filters;

use App\Users\Filters\WarehouseFilter;
use App\Users\Filters\PhoneFilter;
use App\Users\Filters\RoleFilter;

use App\Models\Warehouse;
use App\Models\Role;

class UserFilters
{

    protected $filters = [
        'warehouse_id' => WarehouseFilter::class,
        'role_id' => RoleFilter::class,
        'phone' => PhoneFilter::class,
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
            if($key == 'role_id'){
                $filters['role_id'] = Role::findOrfail($value)->name;
                continue;
            }
        }
        return $filters;
    }

}