<?php

namespace App\Authentication\Repositories;

use Auth;
use Illuminate\Http\Request;
use App\Authentication\Interfaces\LoginRepositoryInterface;
use App\Models\User;

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

    public function Logout($request){
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    }

    public function login_user_by_id($user_id){
        $user = User::findOrFail($user_id);
        if(!$user){ return false; }
        if(!Auth::login($user)){return false;}
        return true;
    }

}