<?php

namespace App\Warehouses\Repositories;

use App\Warehouses\Interfaces\WarehouseCrudRepositoryInterface;
use App\Models\Warehouse;

class WarehouseCrudRepository implements WarehouseCrudRepositoryInterface{

    public function add_warehouse(array $warehouse_details){
        return Warehouse::create($warehouse_details);
    }

    public function get_company_warehouses($company_id){
        return Warehouse::withCount('users')->where('company_id',$company_id)->paginate(10);
    }

    public function get_warehouse_by_id($warehouse_id){
        return Warehouse::findOrFail($warehouse_id);
    }

    public function update_warehouse_by_id($warehouse_id,array $warehouse_details){
        return Warehouse::where(['id'=>$warehouse_id])->update($warehouse_details);
    }

}