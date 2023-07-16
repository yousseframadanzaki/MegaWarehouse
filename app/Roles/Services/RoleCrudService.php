<?php

namespace App\Roles\Services;

use App\Roles\Interfaces\RoleCrudRepositoryInterface;
use App\Roles\Interfaces\RoleCrudServiceInterface;

class RoleCrudService implements RoleCrudServiceInterface{
    
    protected $role_crud_repository;

    public function __construct(RoleCrudRepositoryInterface $role_crud_repository) {
        $this->role_crud_repository = $role_crud_repository;
    }

    public function GetCompanyRoles($company_id){
        return $this->role_crud_repository->get_roles_by_company_id($company_id);
    }

    public function GetPermissions(){
        $permissions = $this->role_crud_repository->get_permissions();
        $permission_classes = [];
        foreach ($permissions as $key => $value) {
            $permission_classes[$value->resource_name][] = $value;
        }
        return $permission_classes;
    }
    

    public function CreateRole($company_id,array $role_details){
        $role_details['company_id'] = $company_id;
        $permissions_ids = $role_details['permissions'];
        return $this->role_crud_repository->create_role_with_permissions($role_details,$permissions_ids);
    }

    public function GetRole($role_id){
        return $this->role_crud_repository->get_role_by_id($role_id);
    }

    public function UpdateRole($role_id,array $role_details){
        return $this->role_crud_repository->update_role_by_id($role_id,$role_details);
    }

    public function CreateOwnerRole($company_id) {
        $role_details = array(
            'company_id' => $company_id,
            'name' => 'owner'
        );
        $permissions_ids = $this->role_crud_repository->get_permissions_ids();
        return $this->role_crud_repository->create_role_with_permissions($role_details,$permissions_ids);
    }

}