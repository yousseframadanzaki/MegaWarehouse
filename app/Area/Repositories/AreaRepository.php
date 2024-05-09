<?php

namespace App\Area\Repositories;

use App\Area\Interfaces\AreaRepositoryInterface;
use App\Models\Area;


class AreaRepository implements AreaRepositoryInterface{
    public function get_all_sectors(){
        return Area::with('city')->orderBy('city_id', 'asc')->get();
    }
    function edit_area($area_id, $price){
        $area = Area::find($area_id);
        echo json_encode($area);
        $area->price = $price;
        $area->save();
    }
}
