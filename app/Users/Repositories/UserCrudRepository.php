<?php

namespace App\Users\Repositories;

use App\Models\User;
use App\Users\Interfaces\UserCrudRepositoryInterface;

class UserCrudRepository implements UserCrudRepositoryInterface{
    
    public function add_user(array $user_details) {
        return User::Create($user_details);
    }
    
    public function update_where(array $filter,array $update){
        return User::where($filter)->update($update);
    }

    public function get_all_users_by_company_id($company_id){
        return User::where('company_id',$company_id)->get();
    }
    
    public function get_user_by_id($company_id,$user_id){
        return User::where(['company_id'=>$company_id,'id'=>$user_id])->first();
    }
}