<?php

namespace App\ShippingAreas\Repositories;

use App\Models\ShippingArea;
use App\ShippingAreas\Interfaces\ShippingAreaRepositoryInterface;

class ShippingAreaRepository implements ShippingAreaRepositoryInterface{
    public function get_shipping_areas_by_shipping_company($shipping_company_id){
        return ShippingArea::with('area')->where('shipping_company_id',$shipping_company_id)->get();
    }

    public function upsert_mapping($data){
        if(isset($data['area_mapping_id'])){
            return ShippingArea::where('id',$data['area_mapping_id'])->update([
                'shipping_company_sector_id' => $data['shipping_area_id'],
                'area_id' => $data['area_id']
            ]);
        }
        return ShippingArea::create([
            'shipping_company_sector_id' => $data['shipping_area_id'],
            'area_id' => $data['area_id'],
            'shipping_company_id' => $data['shipping_company_id']
        ]);
    }

}