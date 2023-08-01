<?php

namespace App\Categories\Interfaces;

interface CategoryCrudServiceInterface{
    public function CreateCategory($company_id,array $details);
    public function UpdateCategory($category_id,array $details);
    public function GetCompanyCategories($company_id);
    public function GetCategory($category_id);
    public function GetCategoryWithProducts($category_id);
}