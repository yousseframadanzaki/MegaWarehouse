<?php

namespace App\Authentication\Services;

use App\Authentication\Interfaces\LoginServiceInterface;
use App\Authentication\Interfaces\LoginRepositoryInterface;

class LoginService implements LoginServiceInterface{

    protected $repository;

    public function __construct(LoginRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function AttemptUserLogin(array $credentials){
        if($this->repository->LoginActiveUserWithPhone($credentials)){
            return true;
        }
        if($this->repository->LoginActiveUserWithEmail($credentials)){
            return true;
        }
        return false;
    }
    public function Logout($request){
        $this->repository->Logout($request);
    }

    public function LoginUserById($user_id)
    {
        if($this->repository->login_user_by_id($user_id)){
            return true;
        }
        return false;
    }

}