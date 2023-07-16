<?php

namespace App\Roles\Repositories;

use App\Models\Role;
use App\Models\Permission;
use App\Roles\Interfaces\RoleCrudRepositoryInterface;

class RoleCrudRepository implements RoleCrudRepositoryInterface{
    
    public function add_role($company_id,array $role_details){
        $role_details['company_id'] = $company_id;
        return Role::Create($role_details);
    }

    public function get_roles_by_company_id($company_id){
        return Role::where('company_id',$company_id)->get();
    }

    public function update_role_by_id($role_id,$role_details){
        $permissions = $role_details['permissions'];
        unset($role_details['permissions']);
        Role::where('id',$role_id)->update($role_details);
        $role = Role::find($role_id);
        $role->permissions()->sync($permissions);
        return $role;
    }

    public function get_role_by_id($role_id){
        return Role::findOrFail($role_id);
    }

    public function get_permissions(){
        return Permission::all();
    }

    public function get_permissions_ids(){
        return Permission::all()->pluck('id')->toArray();
    }

    public function create_role_with_permissions(array $role_details,array $permissions){
        $role = Role::Create($role_details);
        $role->permissions()->sync($permissions);
        return $role;
    }

}