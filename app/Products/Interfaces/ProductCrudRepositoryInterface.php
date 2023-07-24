<?php

namespace App\Products\Interfaces;

interface ProductCrudRepositoryInterface{
    public function add_product(array $product_info);
}