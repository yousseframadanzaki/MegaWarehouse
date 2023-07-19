<?php

namespace App\Clients\Interfaces;

interface ClientCrudRepositoryInterface{
    public function create_client(array $details);
    public function update_client($client_id,array $details);
    public function get_clients_by_company_id($company_id);
    public function get_client_by_id($id);
}