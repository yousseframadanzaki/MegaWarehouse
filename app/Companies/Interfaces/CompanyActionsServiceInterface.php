<?php

namespace App\Companies\Interfaces;

interface CompanyActionsServiceInterface{

    public function Activate($company_id);
    public function Deactivate($company_id);

}