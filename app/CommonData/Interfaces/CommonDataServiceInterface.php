<?php

namespace App\CommonData\Interfaces;

interface CommonDataServiceInterface{
    public function GetCompanyRoles($company_id);
    public function GetCompanyCategories($company_id);
}