<?php

namespace App\ShippingStatus\Interfaces;

interface ShippingStatusServiceInterface{
    public function GetShippingCompanyStatuses($shipping_company);
    public function UpsertMapping($data);
    
}