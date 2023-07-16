<?php

namespace App\Roles\Interfaces;

interface RoleCrudRepositoryInterface{
    public function add_role($company_id,array $role_details);
    public function get_roles_by_company_id($company_id);
    public function update_role_by_id($role_id,$role_details);
    public function get_role_by_id($role_id);
    public function get_permissions();
    public function get_permissions_ids();
    public function create_role_with_permissions(array $role_details,array $permissions);
}