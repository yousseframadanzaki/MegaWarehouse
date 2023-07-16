<?php

namespace App\Roles\Interfaces;

interface RoleCrudServiceInterface{
    public function GetCompanyRoles($company_id);
    public function GetPermissions();
    public function CreateRole($company_id,array $role_details);
    public function GetRole($role_id);
    public function UpdateRole($role_id,array $role_details);
    public function CreateOwnerRole($company_id);
}