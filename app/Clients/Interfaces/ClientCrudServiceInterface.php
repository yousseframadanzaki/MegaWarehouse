<?php

namespace App\Clients\Interfaces;

interface ClientCrudServiceInterface{
    public function CreateClient($company_id,array $details);
    public function UpdateClient($client_id,array $details);
    public function GetCompanyClients($company_id);
    public function GetClient($client_id);
}