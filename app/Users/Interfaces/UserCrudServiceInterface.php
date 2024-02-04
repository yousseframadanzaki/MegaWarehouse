<?php

namespace App\Users\Interfaces;

interface UserCrudServiceInterface{
    public function CreateUser(array $user_details,$company_id);
    public function GetAllUsers($company_id,$filters);
    public function GetUser($company_id,$user_id);
    public function UpdateUserCompanyId($company_id,$user_id);
    public function UpdateUser($user_id,array $user_details);
}