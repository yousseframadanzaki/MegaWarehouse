<?php

namespace App\Companies\Services;

use App\Companies\Interfaces\CompanyCrudRepositoryInterface;
use App\Companies\Interfaces\CompanyCrudServiceInterface;
use App\Users\Interfaces\UserCrudServiceInterface;

class CompanyCrudService implements CompanyCrudServiceInterface{

    protected CompanyCrudRepositoryInterface $company_crud_repository;
    protected UserCrudServiceInterface $UserCrudService;

    public function __construct(
        CompanyCrudRepositoryInterface $company_crud_repository,
        UserCrudServiceInterface $UserCrudService
    ) {
        $this->company_crud_repository = $company_crud_repository;
        $this->UserCrudService = $UserCrudService;
    }

    public function CreateCompany(array $data){
        $company_id = $this->company_crud_repository->add_company($data['company']);
        $user_id = $this->UserCrudService->CreateOwnerUser($data['user'],$company_id);
        return $company_id;
    }
    
    public function GetAllCompanies(){
        return $this->company_crud_repository->get_all_companies();
    }

    public function GetCompany($company_id){
        return $this->company_crud_repository->get_company_by_id($company_id);
    }

    public function UpdateCompany($company_id,array $comapny_details){
        return $this->company_crud_repository->update_company_by_id($company_id,$comapny_details);
    }

}