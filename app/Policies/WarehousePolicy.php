<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Warehouse;
use App\Models\User;

class WarehousePolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_warehouses')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_warehouses')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_warehouses')){
            return false;
        }
        return true;
    }

    public function update(User $user, $warehouse_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_warehouses')){
            return false;
        }
        $warehouse = Warehouse::findOrFail($warehouse_id);
        if($user->company_id != $warehouse->company_id){
            return false;
        }
        return true;
    }
}
