<?php

namespace App\Clients\Services;

use App\Clients\Interfaces\ClientGroupCrudRepositoryInterface;
use App\Clients\Interfaces\ClientGroupCrudServiceInterface;

class ClientGroupCrudService implements ClientGroupCrudServiceInterface{

    protected ClientGroupCrudRepositoryInterface $client_group_crud_repository;

    public function __construct(
        ClientGroupCrudRepositoryInterface $client_group_crud_repository
    ) {
        $this->client_group_crud_repository = $client_group_crud_repository;
    }

    public function CreateClientGroup($company_id,array $details){
        $details['company_id'] = $company_id;
        $client_group = $this->client_group_crud_repository->create_client_group($details);
        return $client_group;
    }

    public function UpdateClientGroup($client_group_id,array $details){
        return $this->client_group_crud_repository->update_client_group($client_group_id,$details);
    }

    public function GetCompanyClientGroups($company_id){
        return $this->client_group_crud_repository->get_client_groups_by_company_id($company_id);       
    }

    public function GetClientGroup($id){
        return $this->client_group_crud_repository->get_client_group_by_id($id);
    }
    
}