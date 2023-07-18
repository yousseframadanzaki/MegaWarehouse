<?php

namespace App\Categories\Interfaces;

interface CategoryCrudServiceInterface{
    public function CreateCategory($company_id,array $details);
    public function UpdateCategory($brand_id,array $details);
    public function GetCompanyCategories($company_id);
    public function GetCategory($brand_id);
}