<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\User;

class UserPolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_users')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_users')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_users')){
            return false;
        }
        return true;
    }

    public function update(User $user, $user_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_users')){
            return false;
        }
        $user = User::findOrFail($user_id);
        if($user->company_id != $user->company_id){
            return false;
        }
        return true;
    }

    public function activate(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','activate_users')){
            return false;
        }
        return true;
    }

    public function activate_user_id(User $user, $user_id): bool
    {
        if(!$user->role->permissions->contains('slug','activate_users')){
            return false;
        }
        $action_user = User::findOrFail($user_id);
        if($user->company_id != $action_user->company_id){
            return false;
        }
        return true;
    }
    
    public function deactivate(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','deactivate_users')){
            return false;
        }
        return true;
    }

    public function deactivate_user_id(User $user, $user_id): bool
    {
        if(!$user->role->permissions->contains('slug','deactivate_users')){
            return false;
        }
        $action_user = User::findOrFail($user_id);
        if($user->company_id != $action_user->company_id){
            return false;
        }
        return true;
    }

}
