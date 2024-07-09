<?php

namespace App\Policies;

use App\Models\User;

class AccountingPolicy
{
    public function view_transactions(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_transactions')){
            return false;
        }

        return true;
    }

    public function add_transaction(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_transaction') || $user->role->user_type_id != 1){
            return false;
        }

        return true;
    }
}
