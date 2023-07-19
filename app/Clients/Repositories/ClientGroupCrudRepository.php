<?php

namespace App\Clients\Repositories;

use App\Models\ClientGroup;
use App\Clients\Interfaces\ClientGroupCrudRepositoryInterface;

class ClientGroupCrudRepository implements ClientGroupCrudRepositoryInterface{

    public function create_client_group(array $details){
        return ClientGroup::create($details);
    }

    public function update_client_group($client_group_id,array $details){
        return ClientGroup::where(['id'=>$client_group_id])->update($details);
    }

    public function get_client_groups_by_company_id($company_id){
        return ClientGroup::withCount('clients')->where('company_id',$company_id)->paginate(10);
    }

    public function get_client_group_by_id($id){
        return ClientGroup::withCount('clients')->where('id', $id)->get()->first();
    }

}