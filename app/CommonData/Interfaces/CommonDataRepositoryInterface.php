<?php

namespace App\CommonData\Interfaces;

interface CommonDataRepositoryInterface{
    public function get_roles_by_company_id($company_id);
}