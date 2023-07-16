<?php

namespace App\Authentication\Interfaces;

interface LoginServiceInterface{

    public function AttemptUserLogin(array $credentials);

    public function Logout($request);

}