<?php

namespace App\Warehouses\Services;

use App\Warehouses\Interfaces\WarehouseCrudRepositoryInterface;
use App\Warehouses\Interfaces\WarehouseCrudServiceInterface;

class WarehouseCrudService implements WarehouseCrudServiceInterface{

    protected WarehouseCrudRepositoryInterface $warehouse_crud_repository;

    public function __construct(
        WarehouseCrudRepositoryInterface $warehouse_crud_repository
    ) {
        $this->warehouse_crud_repository = $warehouse_crud_repository;
    }

    public function CreateWarehouse($company_id,array $details){
        $details['company_id'] = $company_id;
        $warehouse = $this->warehouse_crud_repository->add_warehouse($details);
        return $warehouse;
    }

    public function UpdateWarehouse($warehouse_id,array $details){
        return $this->warehouse_crud_repository->update_warehouse_by_id($warehouse_id,$details);
    }

    public function GetCompanyWarehouses($company_id){
        return $this->warehouse_crud_repository->get_company_warehouses($company_id);       
    }

    public function GetWarehouse($id){
        return $this->warehouse_crud_repository->get_warehouse_by_id($id);
    }
    
}