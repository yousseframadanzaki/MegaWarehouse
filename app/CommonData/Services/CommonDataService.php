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

    public function GetRolesByType($company_id,$type){
        return $this->common_data_repository->get_roles_by_type($company_id,$type);
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
    public function GetCompanyProducts($company_id){
        return $this->common_data_repository->get_company_products($company_id);
    }
    public function GetCompanyProductsData($company_id){
        return $this->common_data_repository->get_company_products_data($company_id);
    }
    public function GetProductVariants($product_id){
        return $this->common_data_repository->get_product_variants($product_id);
    }
    public function GetCompanyUsers($company_id){
        return $this->common_data_repository->get_company_users($company_id);
    }
    public function GetCompanyClients($company_id){
        return $this->common_data_repository->get_company_clients($company_id);
    }
    public function GetProductAttributes($product_id){
        return $this->common_data_repository->get_product_attributes($product_id);
    }

    public function GetVariant($variant_id){
        return $this->common_data_repository->get_variant_by_id($variant_id);
    }

    public function GetCompanyStatuses(){
        return $this->common_data_repository->get_company_statuses();
    }
    public function GetCompanyShippingCompanies($company_id){
        return $this->common_data_repository->get_company_shipping_companies($company_id);
    }

    public function GetCompanyMarketers($company_id){
        return $this->common_data_repository->get_company_marketers($company_id);
    }
    public function GetUsersByRoleType($company_id,$role_type){
        return $this->common_data_repository->get_users_by_role_type($company_id,$role_type);
    }
    public function GetPaymentTypesCategories() {
        return $this->common_data_repository->get_payment_types_categories();
    }
    public function GetPaymentTypesByCategory($category) {
        return $this->common_data_repository->get_payment_types_by_category($category);
    }
}
