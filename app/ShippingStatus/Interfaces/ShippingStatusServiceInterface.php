<?php

namespace App\ShippingStatus\Interfaces;

interface ShippingStatusServiceInterface{
    public function GetShippingCompanyStatuses($shipping_company);
    public function UpsertMapping($data);
    public function GetStatusMapping($shipping_status_id,$shipping_company_id);
}