<?php

namespace App\ShippingAreas\Repositories;

use App\Models\ShippingArea;
use App\ShippingAreas\Interfaces\ShippingAreaRepositoryInterface;

class ShippingAreaRepository implements ShippingAreaRepositoryInterface{
    public function get_shipping_areas_by_shipping_company($shipping_company_id){
        return ShippingArea::with('area')->where('shipping_company_id',$shipping_company_id)->get();
    }

    public function upsert_mapping($data){
        if (empty($data['area_id'])) {
            ShippingArea::find($data['area_mapping_id'])->delete();
            return ['message' => 'deleted'];
        }

        $row = ShippingArea::where([
            'area_id' => $data['area_id'],
            'shipping_company_id' => $data['shipping_company_id']
        ])->first();

        if (empty($row)) {
            if(!empty($data['area_mapping_id'])){
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

        return ['message' => 'فشل التسجيل هذه المنطقة مسجلة مسبقا'];
    }
    public function get_area_sector_id($area_id,$shipping_company_id){
        return ShippingArea::where(
            ['area_id'=>$area_id,
            'shipping_company_id'=>$shipping_company_id
        ])->get()->value('shipping_company_sector_id');
    }

    public function update_shipping_area_active2($data) {
        $row = ShippingArea::where([
            'area_id' => $data['area_id'],
            'shipping_company_id' => $data['shipping_company_id']
        ])->first();

        if (empty($row)) {
            return ShippingArea::create([
                'area_id' => $data['area_id'],
                'shipping_company_id' => $data['shipping_company_id'],
                'shipping_co_cost' => $data['shipping_co_cost']
            ]);
        }

        return ShippingArea::find($row->id)->update(['shipping_co_cost' => $data['shipping_co_cost']]);
    }
}
