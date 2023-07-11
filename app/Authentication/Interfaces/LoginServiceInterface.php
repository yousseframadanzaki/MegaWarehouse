<?php

namespace App\Authentication\Interfaces;

interface LoginServiceInterface{

    public function AttemptUserLogin(array $credentials);

}