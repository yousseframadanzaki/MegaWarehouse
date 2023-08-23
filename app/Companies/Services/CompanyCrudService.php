<?php

namespace App\Companies\Services;

use App\Companies\Interfaces\CompanyCrudRepositoryInterface;
use App\Companies\Interfaces\CompanyCrudServiceInterface;
use App\Users\Interfaces\UserCrudServiceInterface;
use App\Roles\Interfaces\RoleCrudServiceInterface;
use App\Warehouses\Interfaces\WarehouseCrudServiceInterface;

class CompanyCrudService implements CompanyCrudServiceInterface{

    protected CompanyCrudRepositoryInterface $company_crud_repository;
    protected UserCrudServiceInterface $UserCrudService;
    protected RoleCrudServiceInterface $RoleCrudService;
    protected WarehouseCrudServiceInterface $WarehouseCrudService;

    public function __construct(
        CompanyCrudRepositoryInterface $company_crud_repository,
        UserCrudServiceInterface $UserCrudService,
        RoleCrudServiceInterface $RoleCrudService,
        WarehouseCrudServiceInterface $WarehouseCrudService
    ) {
        $this->company_crud_repository = $company_crud_repository;
        $this->UserCrudService = $UserCrudService;
        $this->RoleCrudService = $RoleCrudService;
        $this->WarehouseCrudService = $WarehouseCrudService;
    }

    public function CreateCompany(array $data){
        $company = $this->company_crud_repository->add_company($data['company']);
        $role = $this->RoleCrudService->CreateOwnerRole($company->id);
        $warehouse = $this->WarehouseCrudService->CreateWarehouse($company->id,$data['warehouse']);
        $data['user']['role_id'] = $role->id;
        $data['user']['warehouse_id'] = $warehouse->id;
        $user = $this->UserCrudService->CreateUser($data['user'],$company->id);
        return $company;
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

    public function GetCompanyUsers($company_id){
        return $this->company_crud_repository->get_company_users($company_id);
    }
    
}