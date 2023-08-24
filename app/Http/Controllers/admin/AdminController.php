<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Authentication\Interfaces\LoginServiceInterface;

class AdminController extends Controller
{

    public function __construct(protected readonly LoginServiceInterface $LoginService) {}

    public function index() {
        return view('Admin.dashboard');
    }

    public function login_as_user(Request $request)
    {
        if(!$this->LoginService->LoginUserById($request->input('user_id'))){
            return redirect()->back()->withErrors(['error' => 'login_error']);
        }
        if(!auth()->user()->is_admin){
            return redirect()->intended('dashboard');
        }
        return redirect()->intended('admin_dashboard');
    }

}
