<?php

namespace App\CommonData\Interfaces;

interface CommonDataRepositoryInterface{
    public function get_roles_by_company_id($company_id);
    public function get_categories_by_company_id($company_id);
}