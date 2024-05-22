<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Stock;
use Illuminate\Http\Request;

class stockPolicy
{

    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_stock')){
            return false;
        }

        return true;
    }

    public function destroy(User $user,$operation_ids): bool
    {
        if(!$user->role->permissions->contains('slug','delete_stock')){
            return false;
        }
        $stock = Stock::select('company_id')->whereIn('id',$operation_ids)->pluck('company_id')->toArray();
        $stock = array_unique($stock);
        if(count($stock) > 1 ){
            return false;
        }else if(count($stock) == 1 && $stock[0] != $user->company_id){
            return false;
        }
        return true;
    }

    public function delete(User $user) {
        if(!$user->role->permissions->contains('slug','delete_stock')){
            return false;
        }
        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_stock')){
            return false;
        }

        return true;
    }
    public function move(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','move_stock')){
            return false;
        }

        return true;
    }
    public function view_his_quantity(User $user): bool{
        if(!$user->role->permissions->contains('slug','view_his_warehouse')){
            return false;
        }

        return true;
    }

}
