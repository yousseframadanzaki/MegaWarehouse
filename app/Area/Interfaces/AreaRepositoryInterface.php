<?php

namespace App\Area\Interfaces;

interface AreaRepositoryInterface{
public function get_all_sectors();
public function edit_area($area_id, $price);
}
