<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Role;
use App\Models\User;

class RolePolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_roles')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_roles')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_roles')){
            return false;
        }
        return true;
    }

    public function update(User $user, $role_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_roles')){
            return false;
        }
        $role = role::findOrFail($role_id);
        if($user->company_id != $role->company_id){
            return false;
        }
        return true;
    }
}
