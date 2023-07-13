<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Users\Interfaces\UserCrudServiceInterface;
use App\Users\Interfaces\UserActionsServiceInterface;
use App\Users\Requests\CreateUserRequest;
// use App\Users\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    private UserCrudServiceInterface $UserCrudService;
    private UserActionsServiceInterface $UserActionsService;

    public function __construct(
        UserCrudServiceInterface $UserCrudService,
        UserActionsServiceInterface $UserActionsService
    ){
        $this->UserCrudService = $UserCrudService;
        $this->UserActionsService = $UserActionsService;
    }

    public function create() {
        return view('Users.add');
    }
    
    public function store(CreateUserRequest $request) {
        $company_id = auth()->user()->company_id;
        $user = $this->UserCrudService->CreateUser($request->validated(),$company_id);
        if($user){
            return back()->with('success','user_created_success');
        }
        return back()->with('error','user_created_error');
    }

    public function all() {
        $company_id = auth()->user()->company_id;
        $users = $this->UserCrudService->GetAllUsers($company_id);
        return view('Users.show_all')->with('users',$users);
    }

    public function activate($user_id) {
        $company_id = auth()->user()->company_id;
        if(!$this->UserActionsService->Activate($company_id,$user_id)){
            return back()->with('error','user_activated_error');
        }
        return back()->with('success','user_activated_success');
    }

    public function deactivate($user_id) {
        $company_id = auth()->user()->company_id;
        if(!$this->UserActionsService->Deactivate($company_id,$user_id)){
            return back()->with('error','user_deactivated_error');
        }
        return back()->with('success','user_deactivated_success');
    }

    public function edit($user_id) {
        $company_id = auth()->user()->company_id;
        $user = $this->UserCrudService->GetUser($company_id,$user_id);
        if(!$user){
            return view('404');
        }
        return view('Users.edit')->with('user',$user);
    }

}
