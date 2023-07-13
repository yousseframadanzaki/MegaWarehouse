<?php

namespace App\Companies\Services;

use App\Companies\Interfaces\CompanyCrudRepositoryInterface;
use App\Companies\Interfaces\CompanyActionsServiceInterface;
use App\Users\Interfaces\UserActionsServiceInterface;

class CompanyActionsService implements CompanyActionsServiceInterface{

    protected CompanyCrudRepositoryInterface $company_crud_repository;
    protected UserActionsServiceInterface $UserActionsService;

    public function __construct(
        CompanyCrudRepositoryInterface $company_crud_repository,
        UserActionsServiceInterface $UserActionsService
    ) {
        $this->company_crud_repository = $company_crud_repository;
        $this->UserActionsService = $UserActionsService;
    }

    public function Activate($company_id){
        $this->UserActionsService->ActivateCompanyUsers($company_id);
        return $this->company_crud_repository->update_column($company_id,'active',true);
    }

    public function Deactivate($company_id){
        $this->UserActionsService->DeactivateCompanyUsers($company_id);
        return $this->company_crud_repository->update_column($company_id,'active',false);
    }

}