<?php

namespace App\Authentication\Interfaces;

interface LoginRepositoryInterface{
    public function LoginActiveUserWithEmail(array $credentials);
    public function LoginActiveUserWithPhone(array $credentials);
}