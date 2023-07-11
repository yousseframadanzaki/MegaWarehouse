<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Authentication\Interfaces\LoginServiceInterface;
use App\Authentication\Requests\LoginRequest;



class AuthenticationController extends Controller
{
    private LoginServiceInterface $LoginService;

    public function __construct(LoginServiceInterface $LoginService){
        $this->LoginService = $LoginService;
    }

    public function login(LoginRequest $request) {
        $credentials = $request->validated();
        if($this->LoginService->AttemptUserLogin($credentials)){
            return redirect()->intended('dashboard');
        }
        return redirect()->back()->withErrors(['error' => 'login_error']);
    }

    public function login_form() {
        return view('Authentication.login');
    }

}
