<?php

namespace App\Users\Interfaces;

interface UserCrudServiceInterface{
    public function CreateOwnerUser(array $User_details,$compnay_id);
    public function CreateUser(array $user_details,$company_id);
    public function GetAllUsers($company_id);
    public function GetUser($company_id,$user_id);
}