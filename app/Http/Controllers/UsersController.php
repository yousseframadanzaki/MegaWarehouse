<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Users\Interfaces\UserCrudServiceInterface;
use App\Users\Interfaces\UserActionsServiceInterface;
use App\Users\Requests\CreateUserRequest;
use App\Users\Requests\UpdateUserRequest;
use App\Users\Filters\UserFilters;
use App\CommonData\Interfaces\CommonDataServiceInterface;

class UsersController extends Controller
{
    private UserCrudServiceInterface $UserCrudService;
    private UserActionsServiceInterface $UserActionsService;
    private CommonDataServiceInterface $CommonDataService;

    public function __construct(
        UserCrudServiceInterface $UserCrudService,
        UserActionsServiceInterface $UserActionsService,
        CommonDataServiceInterface $CommonDataService
    ){
        $this->UserCrudService = $UserCrudService;
        $this->UserActionsService = $UserActionsService;
        $this->CommonDataService = $CommonDataService;
    }

    public function create() {
        $company_id = $this->company_id();
        $roles = $this->CommonDataService->GetCompanyRoles($company_id);
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        // dd($roles);
        return view('Dashboard.Users.add')->with(['roles'=>$roles,'warehouses'=>$warehouses]);
    }

    public function store(CreateUserRequest $request) {
        $company_id = $this->company_id();
        $user = $this->UserCrudService->CreateUser($request->validated(),$company_id);
        if($user){
            return back()->with('success','created_success');
        }
        return back()->with('error','created_error');
    }

    public function all(UserFilters $filter) {
        $company_id = $this->company_id();
        $users = $this->UserCrudService->GetAllUsers($company_id,$filter);

        $roles = $this->CommonDataService->GetCompanyRoles($company_id);
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $data = array(
            "warehouses"=>$warehouses,
            "roles"=>$roles,
        );

        return view('Dashboard.Users.show_all')->with(['users'=>$users,'data'=>$data]);
    }

    public function activate($user_id) {
        $company_id = $this->company_id();
        if(!$this->UserActionsService->Activate($company_id,$user_id)){
            return back()->with('error','edit_userd_error');
        }
        return back()->with('success','user_activated_success');
    }

    public function deactivate($user_id) {
        $company_id = $this->company_id();
        if(!$this->UserActionsService->Deactivate($company_id,$user_id)){
            return back()->with('error','user_deactivated_error');
        }
        return back()->with('success','user_deactivated_success');
    }

    public function edit($user_id) {
        $company_id = $this->company_id();
        $user = $this->UserCrudService->GetUser($company_id,$user_id);
        if(!$user){
            return view('404');
        }
        $roles = $this->CommonDataService->GetCompanyRoles($company_id);
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        return view('Dashboard.Users.edit')->with([
            'user'=>$user,
            'roles'=>$roles,
            'warehouses'=>$warehouses
        ]);
    }
    public function update(UpdateUserRequest $request,$user_id) {
        $validatedData = $request->validated();
        unset($validatedData['password2']);
        if(!$this->UserCrudService->UpdateUser($user_id, $validatedData)){
            return back()->with('error','updated_error');
        }
        return back()->with('success','updated_success');
    }
}
