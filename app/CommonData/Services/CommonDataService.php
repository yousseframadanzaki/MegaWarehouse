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

}