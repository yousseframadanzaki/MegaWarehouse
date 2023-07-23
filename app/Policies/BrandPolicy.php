<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Brand;
use App\Models\User;

class BrandPolicy
{

    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_brands')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_brands')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_brands')){
            return false;
        }
        return true;
    }

    public function update(User $user, $brand_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_brands')){
            return false;
        }
        $brand = Brand::findOrFail($brand_id);
        if($user->company_id != $brand->company_id){
            return false;
        }
        return true;
    }
}
