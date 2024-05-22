<?php

namespace App\Policies;

use App\Models\User;

class StatusPolicy
{

    public function view_statuses(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_statuses')){
            return false;
        }
        return true;
    }
}
