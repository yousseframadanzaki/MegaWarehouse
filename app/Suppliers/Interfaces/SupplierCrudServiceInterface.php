<?php

namespace App\Suppliers\Interfaces;

interface SupplierCrudServiceInterface{
    public function CreateSupplier($company_id,array $details);
    public function GetCompanySuppliers($company_id);
    public function GetSupplier($supplier_id);
    public function UpdateSupplier($supplier_id,array $supplier_details);
}