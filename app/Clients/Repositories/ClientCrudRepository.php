<?php

namespace App\Clients\Repositories;

use App\Models\Client;
use App\Clients\Interfaces\ClientCrudRepositoryInterface;

class ClientCrudRepository implements ClientCrudRepositoryInterface{

    public function create_client(array $details){
        return Client::create($details);
    }

    public function update_client($client_id,array $details){
        return Client::where(['id'=>$client_id])->update($details);
    }

    public function get_clients_by_company_id($company_id){
        return Client::with('client_group')->where('company_id',$company_id)->paginate(10);
    }

    public function get_client_by_id($id){
        return Client::with('client_group')->where('id', $id)->get()->first();
    }

    public function get_client_where($filter) {
        return Client::where($filter)->first();
    }

}