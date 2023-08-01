<?php

namespace App\Categories\Interfaces;

interface CategoryCrudRepositoryInterface{
    public function create_category(array $details);
    public function update_category($brand_id,array $details);
    public function get_categories_by_company_id($company_id);
    public function get_category_by_id($id);
    public function get_category_with_products($id);
}