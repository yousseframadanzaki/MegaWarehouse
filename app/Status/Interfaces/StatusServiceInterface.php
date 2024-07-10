<?php

namespace App\Status\Interfaces;

interface StatusServiceInterface{
    public function UpdateStatus($status_id,$edit_order);
    public function UpdateRelatedShipping($data);
    public function AddRelatedStatus($status_id,$related_status);
    public function RemoveRelatedStatus($related_status, $status_id);
    public function UpdateStatusColor($data);
}
