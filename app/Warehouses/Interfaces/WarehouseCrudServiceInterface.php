<?php

namespace App\Warehouses\Interfaces;

interface WarehouseCrudServiceInterface{
    public function CreateWarehouse($company_id,array $details);
    public function GetCompanyWarehouses($company_id);
    public function GetWarehouse($warehouse_id);
    public function UpdateWarehouse($warehouse_id,array $warehouse_details);
}