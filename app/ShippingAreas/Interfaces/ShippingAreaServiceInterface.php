<?php

namespace App\ShippingAreas\Interfaces;

interface ShippingAreaServiceInterface{
    public function GetShippingCompanyAreas($shipping_company);
    public function UpsertMapping($data);
}