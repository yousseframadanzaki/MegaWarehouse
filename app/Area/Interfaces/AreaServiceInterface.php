<?php

namespace App\Area\Interfaces;

interface AreaServiceInterface
{
    public function GetAllSectors();
    public function EditArea($area_id, $price);
    public function EditCity($area_id, $city_id);
    public function EditShippingCompany($area_id, $shipping_company_id);
    public function EditKeywords($area_id, $keywords);
    public function CreateSector($data);
    public function GetPrice($id);
    public function GetKeywords($id);
}
