<?php

namespace App\Users\Interfaces;

interface UserCrudServiceInterface{

    public function CreateOwnerUser(array $User_details,$compnay_id);

}