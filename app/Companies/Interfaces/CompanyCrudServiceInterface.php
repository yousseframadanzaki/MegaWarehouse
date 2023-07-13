<?php

namespace App\Companies\Interfaces;

interface CompanyCrudServiceInterface{
    public function CreateCompany(array $data);
    public function GetAllCompanies();
    public function GetCompany($company_id);
    public function UpdateCompany($company_id,array $comapny_details);
}