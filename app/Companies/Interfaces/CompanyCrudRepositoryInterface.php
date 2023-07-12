<?php

namespace App\Companies\Interfaces;

interface CompanyCrudRepositoryInterface{

    public function add_company(array $company_details);

}