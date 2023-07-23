<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_categories')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_categories')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_categories')){
            return false;
        }
        return true;
    }

    public function update(User $user, $category_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_categories')){
            return false;
        }
        $category = Category::findOrFail($category_id);
        if($user->company_id != $category->company_id){
            return false;
        }
        return true;
    }

    
}
