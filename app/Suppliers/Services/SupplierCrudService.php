<?php

namespace App\Suppliers\Services;

use App\Suppliers\Interfaces\SupplierCrudRepositoryInterface;
use App\Suppliers\Interfaces\SupplierCrudServiceInterface;

class SupplierCrudService implements SupplierCrudServiceInterface{

    protected SupplierCrudRepositoryInterface $supplier_crud_repository;

    public function __construct(
        SupplierCrudRepositoryInterface $supplier_crud_repository
    ) {
        $this->supplier_crud_repository = $supplier_crud_repository;
    }

    public function CreateSupplier($company_id,array $details){
        $details['company_id'] = $company_id;
        $supplier = $this->supplier_crud_repository->add_supplier($details);
        return $supplier;
    }

    public function UpdateSupplier($supplier_id,array $details){
        return $this->supplier_crud_repository->update_supplier_by_id($supplier_id,$details);
    }

    public function GetCompanySuppliers($company_id){
        return $this->supplier_crud_repository->get_company_suppliers($company_id);       
    }

    public function GetSupplier($id){
        return $this->supplier_crud_repository->get_supplier_by_id($id);
    }
    
    public function GetSupplierWithProducts($id){
        return $this->supplier_crud_repository->get_supplier_with_products($id);
    }

}