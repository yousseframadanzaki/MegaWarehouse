<?php

namespace App\Products\Interfaces;

interface ProductAttributesRepositoryInterface{
    public function add_attributes($product_id,array $attributes);
}