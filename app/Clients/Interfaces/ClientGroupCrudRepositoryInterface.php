<?php

namespace App\Clients\Interfaces;

interface ClientGroupCrudRepositoryInterface{
    public function create_client_group(array $details);
    public function update_client_group($client_group_id,array $details);
    public function get_client_groups_by_company_id($company_id);
    public function get_client_group_by_id($id);
}