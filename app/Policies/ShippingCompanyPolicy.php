<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ShippingCompany;

class ShippingCompanyPolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_shipping_companies')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_shipping_companies')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_shipping_companies')){
            return false;
        }
        return true;
    }

    public function update(User $user, $shipping_company_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_shipping_companies')){
            return false;
        }
        $shipping_company = ShippingCompany::findOrFail($shipping_company_id);
        if($user->company_id != $shipping_company->company_id){
            return false;
        }
        return true;
    }

    public function view_orders(User $user): bool {
        if(!$user->role->permissions->contains('slug','view_shipping_company_orders')){
            return false;
        }

        return true;
    }
}
