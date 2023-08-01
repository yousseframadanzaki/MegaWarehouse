<?php

namespace App\Products\Interfaces;

interface ProductVariantsRepositoryInterface{
    public function add_default_variant($product);
    public function add_variants($product_id,$attributes,$variants);
    public function get_variant_by_id($variant_id);
}