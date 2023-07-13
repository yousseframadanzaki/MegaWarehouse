<?php

namespace App\Users\Services;

use App\Users\Interfaces\UserActionsServiceInterface;
use App\Users\Interfaces\UserCrudRepositoryInterface;

class UserActionsService implements UserActionsServiceInterface{
    
    protected $user_crud_repository;

    public function __construct(UserCrudRepositoryInterface $user_crud_repository) {
        $this->user_crud_repository = $user_crud_repository;
    }

    public function ActivateCompanyUsers($company_id){
        $this->user_crud_repository->update_where(
            ['company_id'=> $company_id],
            ['active' => true]
        );
    }
    
    public function DeactivateCompanyUsers($company_id){
        $this->user_crud_repository->update_where(
            ['company_id'=> $company_id],
            ['active' => false]
        );
    }

    public function Activate($company_id,$user_id) {
        return $this->user_crud_repository->update_where(
            ['company_id'=> $company_id,'id'=> $user_id ],
            ['active' => true]
        );
    }
    public function Deactivate($company_id,$user_id) {
        return $this->user_crud_repository->update_where(
            ['company_id'=> $company_id,'id'=> $user_id ],
            ['active' => false]
        );
    }

}