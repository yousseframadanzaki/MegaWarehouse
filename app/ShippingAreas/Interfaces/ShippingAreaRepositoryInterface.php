<?php

namespace App\ShippingAreas\Interfaces;

interface ShippingAreaRepositoryInterface{
    public function get_shipping_areas_by_shipping_company($shipping_company_id);
    public function upsert_mapping($data);
    public function get_area_sector_id($area_id,$shipping_company_id);
}