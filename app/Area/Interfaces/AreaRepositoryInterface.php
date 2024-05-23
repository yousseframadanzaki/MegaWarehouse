<?php

namespace App\Area\Interfaces;

interface AreaRepositoryInterface{
public function get_all_sectors();
public function edit_area($area_id, $price);
public function edit_city($area_id, $city_id);
public function edit_shipping_company($area_id, $shipping_company_id);
public function edit_keywords($area_id, $keywords);
public function create_sector($data);
public function get_price($id);
public function get_keywords($id);
}
