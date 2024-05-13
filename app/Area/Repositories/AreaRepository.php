<?php

namespace App\Area\Repositories;

use App\Area\Interfaces\AreaRepositoryInterface;
use App\Models\Area;


class AreaRepository implements AreaRepositoryInterface{
    public function get_all_sectors(){
        return Area::with('city','shipping_company')->orderBy('city_id', 'asc')->get();
    }
    function edit_area($area_id, $price){
        $area = Area::find($area_id);
        echo json_encode($area);
        $area->price = $price;
        $area->save();
    }
    public function edit_city($area_id, $city_id){
        $area = Area::find($area_id);
        echo json_encode($area);
        $area->city_id = $city_id;
        $area->save();
    }
    public function edit_shipping_company($area_id, $shipping_company_id){
        $area = Area::find($area_id);
        echo json_encode($area);
        $area->shipping_company_id = $shipping_company_id;
        $area->save();
    }
    public function create_sector($data){
        return Area::create($data);
    }
}
