<?php

namespace App\Suppliers\Interfaces;

interface SupplierCrudRepositoryInterface{
    public function add_supplier(array $supplier_details);
    public function get_company_suppliers($company_id);
    public function get_supplier_by_id($supplier_id);
    public function update_supplier_by_id($supplier_id,array $supplier_details);
}