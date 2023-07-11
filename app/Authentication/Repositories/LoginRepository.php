<?php

namespace App\Authentication\Repositories;

use Auth;
use App\Authentication\Interfaces\LoginRepositoryInterface;


class LoginRepository implements LoginRepositoryInterface{



    public function LoginActiveUserWithEmail(array $credentials){
        if (Auth::attempt(['email' => $credentials['identity'], 'password' => $credentials['password'],'active' => 1])) {
            return true;
        }
        return false;
    }


    public function LoginActiveUserWithPhone(array $credentials){
        if (Auth::attempt(['phone_1' => $credentials['identity'], 'password' => $credentials['password'],'active' => 1])) {
            return true;
        }
        return false;
    }
}