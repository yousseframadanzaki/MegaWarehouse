<?php

namespace App\Products\Interfaces;

interface ProductVariantsRepositoryInterface{
    public function add_default_variant(array $product);
    public function add_variants($product_id,$attributes,$variants);
}