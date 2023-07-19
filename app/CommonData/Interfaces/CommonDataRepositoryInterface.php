<?php

namespace App\CommonData\Interfaces;

interface CommonDataRepositoryInterface{
    public function get_roles_by_company_id($company_id);
    public function get_categories_by_company_id($company_id);
    public function get_client_groups_by_company_id($company_id);
    public function get_countries();
    public function get_cities($country_id=NULL);
    public function get_areas($city_id=NULL);
}