<?php

namespace App\Status\Interfaces;

interface StatusServiceInterface{
    public function UpdateStatus($status_id, array $data);
    public function AddRelatedStatus($status_id,$related_status);
    public function RemoveRelatedStatus($related_status, $status_id);
    public function GetStatues();
}
