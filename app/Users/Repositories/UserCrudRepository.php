<?php

namespace App\Users\Repositories;

use App\Models\User;
use App\Users\Interfaces\UserCrudRepositoryInterface;

class UserCrudRepository implements userCrudRepositoryInterface{
    
    public function add_user(array $user_details) {
        return user::Create($user_details);
    }

}