<?php

namespace App\Products\Interfaces;

interface ProductCrudRepositoryInterface{
    public function add_product(array $product_info);
    public function get_products_by_company_id($company_id);
}