<?php

namespace App\Authentication\Interfaces;
use Illuminate\Http\Request;

interface LoginRepositoryInterface{
    public function LoginActiveUserWithEmail(array $credentials);
    public function LoginActiveUserWithPhone(array $credentials);
    public function Logout($request);
}