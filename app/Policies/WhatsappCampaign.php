<?php

namespace App\Policies;

use App\Models\User;

class WhatsappCampaign
{
    public function add_points(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_points')){
            return false;
        }

        return true;
    }

    public function whatsapp_campaigns(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','whatsapp_campaigns')){
            return false;
        }

        return true;
    }

    public function whatsapp_order(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','whatsapp_order')){
            return false;
        }

        return true;
    }
}
