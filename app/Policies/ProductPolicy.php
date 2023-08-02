<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Models\Variant;

class ProductPolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_products')){
            return false;
        }

        return true;
    }

    public function view_one(User $user,$product_id): bool
    {
        if(!$user->role->permissions->contains('slug','view_products')){
            return false;
        }
        $product = Product::findOrFail($product_id);
        if($user->company_id != $product->company_id){
            return false;
        }
        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_products')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_products')){
            return false;
        }
        return true;
    }

    public function update(User $user, $product_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_products')){
            return false;
        }
        $product = Product::findOrFail($product_id);
        if($user->company_id != $product->company_id){
            return false;
        }
        return true;
    }

    public function print(User $user, $variant_id): bool
    {
        $variant = Variant::findOrFail($variant_id);
        if($user->company_id != $variant->product->company_id){
            return false;
        }
        return true;
    }
}
