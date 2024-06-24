<?php

namespace App\Products\Interfaces;

interface ProductCrudRepositoryInterface{
    public function add_product(array $product_info);
    public function get_products_by_company_id($company_id,$filters);
    public function get_product_by_id($product_id);
    public function update_product_by_id($product_id,array $product_info);
    public function delete_product($product_id);
}
