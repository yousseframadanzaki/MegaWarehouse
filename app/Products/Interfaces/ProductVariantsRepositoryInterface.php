<?php

namespace App\Products\Interfaces;

interface ProductVariantsRepositoryInterface{
    public function add_default_variant($product);
    public function add_variants($product_id,$attributes,$variants);
    public function get_variant_by_id($variant_id);
    public function update_variant_by_id($variant_id,$data);
    public function get_variant_by_id_no_relations($variant_id);
    public function add_variant_stock_by_id($variant_id);
    public function update_variant_shelf($variant_id, $shelf);
    public function get_variants(array $variants_ids);
    public function get_all_variants($page);
    public function delete_variant($variant_id, $is_bundle);
    public function get_variant_shelf_data(array $data);
    public function incomplete_orders_variants($company_id);
}
