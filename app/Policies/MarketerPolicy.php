<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Marketer;

class MarketerPolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_marketers')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_marketers')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_marketers')){
            return false;
        }
        return true;
    }

    public function update(User $user, $marketer_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_marketers')){
            return false;
        }
        $marketer = Marketer::findOrFail($marketer_id);
        if($user->company_id != $marketer->company_id){
            return false;
        }
        return true;
    }
}
