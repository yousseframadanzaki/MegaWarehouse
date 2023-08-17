<?php

namespace App\ShippingAreas\Interfaces;

interface ShippingAreaRepositoryInterface{
    public function get_shipping_areas_by_shipping_company($shipping_company_id);
    public function upsert_mapping($data);
}