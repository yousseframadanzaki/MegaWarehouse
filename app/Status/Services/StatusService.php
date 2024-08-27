<?php

namespace App\Status\Services;

use App\Status\Interfaces\StatusRepositoryInterface;
use App\Status\Interfaces\StatusServiceInterface;



class StatusService implements StatusServiceInterface{

    public function __construct(
        protected readonly StatusRepositoryInterface $status_crud_repository,
    ) {}
    public function UpdateStatus($status_id, array $data){
        return $this->status_crud_repository->update_status($status_id,$data);
    }
    public function AddRelatedStatus($status_id,$related_status){
        return $this->status_crud_repository->add_related_status($status_id,$related_status);
    }
    public function RemoveRelatedStatus($related_status, $status_id){
        return $this->status_crud_repository->remove_related_status($related_status, $status_id);
    }
    public function GetStatues() {
        return $this->status_crud_repository->get_statues();
    }
}
