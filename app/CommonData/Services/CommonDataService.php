<?php

namespace App\CommonData\Services;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\CommonData\Interfaces\CommonDataRepositoryInterface;

class CommonDataService implements CommonDataServiceInterface{

    protected CommonDataRepositoryInterface $common_data_repository;

    public function __construct(CommonDataRepositoryInterface $common_data_repository){
        $this->common_data_repository = $common_data_repository;
    }

    public function GetCompanyRoles($company_id){
        return $this->common_data_repository->get_roles_by_company_id($company_id);
    }
    
    public function GetCompanyCategories($company_id){
        return $this->common_data_repository->get_categories_by_company_id($company_id);
    }

    public function GetCompanyBrands($company_id){
        return $this->common_data_repository->get_brands_by_company_id($company_id);
    }

    public function GetSubCategories($category_id){
        return $this->common_data_repository->get_sub_categories($category_id);
    }

    public function GetCompanySuppliers($company_id){
        return $this->common_data_repository->get_suppliers_by_company_id($company_id);
    }

    public function GetCompanyClientGroups($company_id){
        return $this->common_data_repository->get_client_groups_by_company_id($company_id);
    }

    public function GetCountries(){
        return $this->common_data_repository->get_countries();
    }

    public function GetCities($country_id=NULL){
        return $this->common_data_repository->get_cities($country_id);
    }

    public function GetAreas($city_id=NULL){
        return $this->common_data_repository->get_areas($city_id);
    }

    public function GetCompanyWarehouses($company_id){
        return $this->common_data_repository->get_company_warehouses($company_id);
    }


}