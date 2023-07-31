<?php

namespace App\Brands\Interfaces;

interface BrandCrudServiceInterface{
    public function CreateBrand($company_id,array $details);
    public function UpdateBrand($brand_id,array $details);
    public function GetCompanyBrands($company_id);
    public function GetBrand($brand_id);
    public function GetBrandWithProducts($id);
}