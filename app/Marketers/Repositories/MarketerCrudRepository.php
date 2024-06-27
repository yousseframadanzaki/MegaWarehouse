<?php

namespace App\Marketers\Repositories;

use App\Marketers\Interfaces\MarketerCrudRepositoryInterface;

use App\Models\Marketer;

class MarketerCrudRepository implements MarketerCrudRepositoryInterface{

    public function create_marketer(array $details){
        return Marketer::create($details);
    }

    public function update_marketer($marketer_id,array $details){
        return Marketer::where(['id'=>$marketer_id])->update($details);
    }

    public function get_marketers_by_company_id($company_id){
        return Marketer::withCount('orders')
        ->withSum('orders AS total_commission', 'total_marketer_commission')
        ->with('user', function($query) {
            $query->withSum('to_transactions AS total_transactions', 'value');
        })
        ->where('company_id',$company_id)
        ->paginate(10);
    }

    public function get_marketer_by_id($id){
        $marketer = Marketer::withCount('orders')
        ->withSum('orders AS total_commission', 'total_marketer_commission')
        ->with('user', function($query) {
            $query->withSum('to_transactions AS total_transactions', 'value');
        })
        ->find($id);
        return $marketer;
    }
}
