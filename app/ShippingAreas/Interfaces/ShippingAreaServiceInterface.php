<?php

namespace App\ShippingAreas\Interfaces;

interface ShippingAreaServiceInterface{
    public function GetShippingCompanyAreas($shipping_company);
    public function UpsertMapping($data);
    public function GetAreaSectorIdMapping($area_id,$shipping_company_id);
    public function UpdateShippingAreaActive2($data);
}
