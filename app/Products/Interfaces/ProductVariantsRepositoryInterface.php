<?php

namespace App\Products\Interfaces;

interface ProductVariantsRepositoryInterface{
    public function add_default_variant($product);
    public function add_variants($product_id,$attributes,$variants);
    public function get_variant_by_id($variant_id);
    public function update_variant_by_id($variant_id,$data);
    public function get_variant_by_id_no_relations($variant_id);
    public function add_variant_stock_by_id($variant_id,$quantity);
}
