<?php

namespace App\CommonData\Interfaces;

interface CommonDataRepositoryInterface{
    public function get_roles_by_company_id($company_id);
    public function get_categories_by_company_id($company_id);
    public function get_suppliers_by_company_id($company_id);
    public function get_brands_by_company_id($company_id);
    public function get_sub_categories($category_id);
    public function get_client_groups_by_company_id($company_id);
    public function get_countries();
    public function get_cities($country_id=NULL);
    public function get_areas($city_id=NULL);
    public function get_company_warehouses($company_id);
    public function get_company_products($company_id);
    public function get_company_users($company_id);
}