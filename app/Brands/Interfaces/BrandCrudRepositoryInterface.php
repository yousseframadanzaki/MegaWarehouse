<?php

namespace App\Brands\Interfaces;

interface BrandCrudRepositoryInterface{
    public function create_brand(array $details);
    public function update_brand($brand_id,array $details);
    public function get_brands_by_company_id($company_id);
    public function get_brand_by_id($id);
}