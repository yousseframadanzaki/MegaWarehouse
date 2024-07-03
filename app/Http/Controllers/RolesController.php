<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Roles\Interfaces\RoleCrudServiceInterface;
use App\Roles\Requests\CreateRoleRequest;
use App\Roles\Requests\UpdateRoleRequest;

class RolesController extends Controller
{

    private RoleCrudServiceInterface $RoleCrudService;

    public function __construct(RoleCrudServiceInterface $RoleCrudService){
        $this->RoleCrudService = $RoleCrudService;
    }

    public function all() {
        $company_id = $this->company_id();
        $roles = $this->RoleCrudService->GetCompanyRoles($company_id);
        return view('Dashboard.Roles.show_all')->with('roles',$roles);
    }

    public function create() {
        $permission_classes = $this->RoleCrudService->GetPermissions();
        return view('Dashboard.Roles.add')->with('permission_classes',$permission_classes);
    }

    public function store(CreateRoleRequest $request) {
        $company_id = $this->company_id();
        $role = $this->RoleCrudService->CreateRole($company_id,$request->validated());
        if(!$role){
            return back()->with('error',trans('global.created_error'));
        }
        return back()->with('success',trans('global.created_success'));
    }

    public function edit($role_id) {
        $role = $this->RoleCrudService->GetRole($role_id);
        $permission_classes = $this->RoleCrudService->GetPermissions();
        $data['role'] = $role;
        $data['permission_classes'] = $permission_classes;
        return view('Dashboard.Roles.edit')->with('data',$data);
    }

    public function update(UpdateRoleRequest $request,$role_id) {
        $role = $this->RoleCrudService->UpdateRole($role_id,$request->validated());
        if(!$role){
            return back()->with('error',trans('global.updated_error'));
        }
        return back()->with('success',trans('global.updated_success'));
    }

}
