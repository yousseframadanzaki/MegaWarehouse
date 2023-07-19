<?php

namespace App\Clients\Interfaces;

interface ClientGroupCrudServiceInterface{
    public function CreateClientGroup($company_id,array $details);
    public function UpdateClientGroup($client_group_id,array $details);
    public function GetCompanyClientGroups($company_id);
    public function GetClientGroup($client_group_id);
}