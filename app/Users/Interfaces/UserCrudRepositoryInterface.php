<?php

namespace App\Users\Interfaces;

interface UserCrudRepositoryInterface{

    public function add_user(array $User_details);
    public function update_where(array $filter,array $update);
    public function get_all_users_by_company_id($company,$filters);
    public function get_user_by_id($company_id,$user_id);
    public function check_max_users($company_id);
}