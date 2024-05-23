<?php

namespace App\Status\Interfaces;

interface StatusServiceInterface{
    public function UpdateStatus($status_id,$edit_order);
    public function AddRelatedStatus($status_id,$related_status);
    public function RemoveRelatedStatus($related_status, $status_id);
}
