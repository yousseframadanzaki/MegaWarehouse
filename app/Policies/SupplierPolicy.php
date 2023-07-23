<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Supplier;
use App\Models\User;

class SupplierPolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_suppliers')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_suppliers')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_suppliers')){
            return false;
        }
        return true;
    }

    public function update(User $user, $supplier_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_suppliers')){
            return false;
        }
        $supplier = Supplier::findOrFail($supplier_id);
        if($user->company_id != $supplier->company_id){
            return false;
        }
        return true;
    }
}
