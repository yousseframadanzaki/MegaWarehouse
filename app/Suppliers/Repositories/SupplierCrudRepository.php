<?php

namespace App\Suppliers\Repositories;

use App\Suppliers\Interfaces\SupplierCrudRepositoryInterface;
use App\Models\Supplier;

class SupplierCrudRepository implements SupplierCrudRepositoryInterface{

    public function add_supplier(array $supplier_details){
        return Supplier::create($supplier_details);
    }

    public function get_company_suppliers($company_id){
        return Supplier::where('company_id',$company_id)->get();
    }

    public function get_supplier_by_id($supplier_id){
        return Supplier::findOrFail($supplier_id);
    }

    public function update_supplier_by_id($supplier_id,array $supplier_details){
        return Supplier::where(['id'=>$supplier_id])->update($supplier_details);
    }


}