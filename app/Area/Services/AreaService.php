<?php

namespace App\Area\Services;

use App\Area\Interfaces\AreaRepositoryInterface;
use App\Area\Interfaces\AreaServiceInterface;



class AreaService implements AreaServiceInterface{

    public function __construct(
        protected readonly  AreaRepositoryInterface $area_crud_repository,
    ) {}
    public function GetAllSectors(){
        return $this->area_crud_repository->get_all_sectors();
    }
    public function EditArea($area_id, $price){
        return $this->area_crud_repository->edit_area($area_id, $price);
    }
    public function EditCity($area_id, $city_id){
        return $this->area_crud_repository->edit_city($area_id, $city_id);
    }
    public function EditShippingCompany($area_id, $shipping_company_id){
        return $this->area_crud_repository->edit_shipping_company($area_id, $shipping_company_id);
    }
    public function CreateSector($data){
        return $this->area_crud_repository->create_sector($data);
    }
}
