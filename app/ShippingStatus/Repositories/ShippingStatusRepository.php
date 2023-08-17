<?php

namespace App\ShippingStatus\Repositories;

use App\Models\ShippingStatus;
use App\ShippingStatus\Interfaces\ShippingStatusRepositoryInterface;

class ShippingStatusRepository implements ShippingStatusRepositoryInterface{
    public function get_shipping_statuses_by_shipping_company($shipping_company_id){
        return ShippingStatus::with('status')->where('shipping_company_id',$shipping_company_id)->get();
    }

    public function upsert_mapping($data){
        if(isset($data['status_mapping_id'])){
            return ShippingStatus::where('id',$data['status_mapping_id'])->update([
                'shipping_company_status_id' => $data['shipping_status_id'],
                'status_id' => $data['status_id']
            ]);
        }
        return ShippingStatus::create([
            'shipping_company_status_id' => $data['shipping_status_id'],
            'status_id' => $data['status_id'],
            'shipping_company_id' => $data['shipping_company_id']
        ]);
    }

}