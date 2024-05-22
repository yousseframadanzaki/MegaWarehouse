<?php

namespace App\Status\Repositories;

use App\Status\Interfaces\StatusRepositoryInterface;
use App\Models\Status;


class StatusRepository implements StatusRepositoryInterface{
    public function update_status($status_id,$edit_order){
        return Status::where(['id'=>$status_id])->update(['edit_order'=>$edit_order]);
    }
    public function add_related_status($status_id, $related_status){
        $status = Status::find($status_id);
        $current_related_status = $status->related_status;
        $current_related_status .= "," . $related_status;
        $status->related_status = $current_related_status;
        $status->save();
        return true;
    }
}
