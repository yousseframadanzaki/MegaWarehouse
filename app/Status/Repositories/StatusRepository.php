<?php

namespace App\Status\Repositories;

use App\Status\Interfaces\StatusRepositoryInterface;
use App\Models\Status;


class StatusRepository implements StatusRepositoryInterface{
    public function update_status($status_id, array $data){
        return Status::find($status_id)
        ->update($data);
    }
    public function add_related_status($status_id, $related_status){
        $status = Status::find($status_id);
        $current_related_status = $status->related_status;
        $current_related_status .= "," . $related_status;
        $status->related_status = $current_related_status;
        $status->save();
        return true;
    }
    public function remove_related_status($related_status, $status_id){
        $status = Status::find($status_id);
        if ($status) {
            $relatedStatusIds = explode(',', $status->related_status);

            $relatedStatusIds = array_filter($relatedStatusIds, function($value) use ($related_status) {
                return $value != $related_status;
            });
            $status->related_status = implode(',', $relatedStatusIds);
            $status->save();
            return true;
        }
    }
    public function get_statues() {
        return Status::get();
    }
}
