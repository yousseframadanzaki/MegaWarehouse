<?php

namespace App\ShippingStatus\Interfaces;

interface ShippingStatusRepositoryInterface{
    public function get_shipping_statuses_by_shipping_company($shipping_company_id);
    public function upsert_mapping($data);
    public function get_status_mapping($shipping_status_id,$shipping_company_id);
}