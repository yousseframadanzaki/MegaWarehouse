<?php

namespace App\Users\Repositories;

use App\Models\User;
use App\Models\Company;
use App\Users\Interfaces\UserCrudRepositoryInterface;

class UserCrudRepository implements UserCrudRepositoryInterface{
    
    public function add_user(array $user_details) {
        return User::Create($user_details);
    }
    
    public function update_where(array $filter,array $update){
        return User::where($filter)->update($update);
    }

    public function get_all_users_by_company_id($company_id){
        return User::with(['avatar','role','warehouse'])->where('company_id',$company_id)->paginate(10);
    }
    
    public function get_user_by_id($company_id,$user_id){
        return User::where(['company_id'=>$company_id,'id'=>$user_id])->first();
    }
    public function check_max_users($company_id)
    {   
        $company = Company::find($company_id);
        $max_users = $company->max_users;
        $current_users = User::where(['company_id'=>$company_id])->count();
        if($current_users + 1 > $max_users){
            return false;
        }
        return true;
    }
}