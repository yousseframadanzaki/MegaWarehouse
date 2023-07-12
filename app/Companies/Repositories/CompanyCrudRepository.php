<?php

namespace App\Companies\Repositories;

use App\Models\Company;
use App\Companies\Interfaces\CompanyCrudRepositoryInterface;

class CompanyCrudRepository implements CompanyCrudRepositoryInterface{
    
    public function add_company(array $company_details) {
        return Company::Create($company_details)->id;
    }

}