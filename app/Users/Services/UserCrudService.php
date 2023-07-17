<?php

namespace App\Users\Services;

use App\Users\Interfaces\UserCrudServiceInterface;
use App\Users\Interfaces\UserCrudRepositoryInterface;

class UserCrudService implements UserCrudServiceInterface{
    
    protected $user_crud_repository;

    public function __construct(UserCrudRepositoryInterface $user_crud_repository) {
        $this->user_crud_repository = $user_crud_repository;
    }

    public function CreateUser(array $user_details,$company_id){
        $user_details['company_id'] = $company_id;
        return $this->user_crud_repository->add_user($user_details);
    }

    public function GetAllUsers($company_id){
        return $this->user_crud_repository->get_all_users_by_company_id($company_id);
    }

    public function GetUser($company_id,$user_id) {
        return $this->user_crud_repository->get_user_by_id($company_id,$user_id);
    }
    
    public function UpdateUserCompanyId($company_id,$user_id){
        return $this->user_crud_repository->update_where(
            ['id'=> $user_id ],
            ['company_id'=> $company_id]
        );
    }
    public function UpdateUser($user_id,array $user_details) {
        if(!$user_details['password']){
            unset($user_details['password']);
        }
        return $this->user_crud_repository->update_where(
            ['id'=> $user_id ],
            $user_details
        );
    }

}