<?php

namespace App\Clients\Services;

use App\Clients\Interfaces\ClientCrudRepositoryInterface;
use App\Clients\Interfaces\ClientCrudServiceInterface;

class ClientCrudService implements ClientCrudServiceInterface{

    protected ClientCrudRepositoryInterface $client_crud_repository;

    public function __construct(
        ClientCrudRepositoryInterface $client_crud_repository
    ) {
        $this->client_crud_repository = $client_crud_repository;
    }

    public function CreateClient($company_id,array $details){
        $details['company_id'] = $company_id;
        if(isset($details['links'])){
            $details['links'] = json_encode($details['links'],true);
        }
        // dd($details);
        $client = $this->client_crud_repository->create_Client($details);
        return $client;
    }

    public function UpdateClient($client_id,array $details){
        return $this->client_crud_repository->update_client($client_id,$details);
    }

    public function GetCompanyClients($company_id){
        return $this->client_crud_repository->get_clients_by_company_id($company_id);       
    }

    public function GetClient($id){
        return $this->client_crud_repository->get_client_by_id($id);
    }
    
}