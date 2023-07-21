<?php

namespace App\Warehouses\Interfaces;

interface WarehouseCrudRepositoryInterface{
    public function add_warehouse(array $warehouse_details);
    public function get_company_warehouses($company_id);
    public function get_warehouse_by_id($warehouse_id);
    public function update_warehouse_by_id($warehouse_id,array $warehouse_details);
}