<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Template;
use App\Models\User;

class TemplatePolicy
{
    public function view(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_templates')){
            return false;
        }

        return true;
    }

    public function add(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_templates')){
            return false;
        }

        return true;
    }

    public function edit(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_templates')){
            return false;
        }
        return true;
    }

    public function update(User $user, $supplier_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_templates')){
            return false;
        }
        $supplier = Template::findOrFail($supplier_id);
        if($user->company_id != $supplier->company_id){
            return false;
        }
        return true;
    }
    public function send_whatsapp(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','send_whatsapp')){
            return false;
        }
        return true;
    }
}
