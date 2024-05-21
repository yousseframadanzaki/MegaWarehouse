<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;

class OrderPolicy
{

    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_orders')){
            return false;
        }

        return true;
    }

    public function view_one(User $user,$order_id): bool
    {
        if(!$user->role->permissions->contains('slug','view_orders')){
            return false;
        }
        $order = Order::findOrFail($order_id);
        if($user->company_id != $order->company_id){
            return false;
        }
        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_orders')){
            return false;
        }

        return true;
    }

    public function edit_change_status(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','change_order_status')){
            return false;
        }
        return true;
    }
    public function edit_order(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_order')){
            return false;
        }
        return true;
    }
    public function scan_orders(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','scan_orders')){
            return false;
        }
        return true;
    }

    public function change_status(User $user, $order_id): bool
    {
        if(!$user->role->permissions->contains('slug','change_order_status')){
            return false;
        }
        $order = Order::findOrFail($order_id);
        if($user->company_id != $order->company_id){
            return false;
        }
        return true;

    }
    public function print_order(User $user){
        return true;
    }
    public function print_orders(User $user){
        return true;
    }
    public function print_label(User $user){
        return true;
    }
    public function print_labels(User $user){
        return true;
    }
    public function add_discount(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_discount')){
            return false;
        }
        return true;
    }
}
