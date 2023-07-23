<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Client;
use App\Models\ClientGroup;

class ClientPolicy
{
    public function view_clients(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_clients')){
            return false;
        }

        return true;
    }

    public function add_client(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_clients')){
            return false;
        }

        return true;
    }

    public function edit_client(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_clients')){
            return false;
        }
        return true;
    }

    public function update_client(User $user, $client_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_clients')){
            return false;
        }
        $client = Client::findOrFail($client_id);
        if($user->company_id != $client->company_id){
            return false;
        }
        return true;
    }
    
    public function view_client_group(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','view_client_groups')){
            return false;
        }

        return true;
    }

    public function add_client_group(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','add_client_groups')){
            return false;
        }

        return true;
    }

    public function edit_client_group(User $user): bool
    {
        if(!$user->role->permissions->contains('slug','edit_client_groups')){
            return false;
        }
        return true;
    }

    public function update_client_group(User $user, $client_id): bool
    {
        if(!$user->role->permissions->contains('slug','edit_client_groups')){
            return false;
        }
        $client = ClientGroup::findOrFail($client_id);
        if($user->company_id != $client->company_id){
            return false;
        }
        return true;
    }
}
