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
}
