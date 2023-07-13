<?php

namespace App\Users\Interfaces;

interface UserActionsServiceInterface{

    public function ActivateCompanyUsers($company_id);
    public function DeactivateCompanyUsers($company_id);

}