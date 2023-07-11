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

}