<?php

namespace App\Products\Services;

use App\Products\Interfaces\ProductVariantsRepositoryInterface;


use App\Products\Interfaces\VariantStockServiceInterface;

class VariantStockService implements VariantStockServiceInterface{


    public function __construct(
        protected readonly  ProductVariantsRepositoryInterface $product_variants_repository,
    ) {}

    public function UpdateStock($variant_id,$quantity) {
        $variant = $this->product_variants_repository->get_variant_by_id($variant_id);
        $new_quantity = $variant->quantity + $quantity;
        $this->product_variants_repository->update_variant_by_id($variant_id,['quantity'=>$new_quantity]);
    }

}