<?php

namespace App\CommonData\Interfaces;

interface CommonDataServiceInterface{
    public function GetCompanyRoles($company_id);
    public function GetCompanyCategories($company_id);
    public function GetCompanySuppliers($company_id);
    public function GetCompanyBrands($company_id);
    public function GetSubCategories($category_id);
    public function GetCompanyClientGroups($company_id);
    public function GetCountries();
    public function GetCities($country_id=NULL);
    public function GetAreas($city_id=NULL);
    public function GetCompanyWarehouses($company_id);
    public function GetCompanyProducts($company_id);
    public function GetCompanyUsers($company_id);
}