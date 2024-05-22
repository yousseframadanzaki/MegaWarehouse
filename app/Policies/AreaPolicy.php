<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Area;

class AreaPolicy
{

    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_sectors')){
            return false;
        }

        return true;
    }
    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_sector')){
            return false;
        }

        return true;
    }
    public function edit_area(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_sector')){
            return false;
        }
        return true;
    }

}
