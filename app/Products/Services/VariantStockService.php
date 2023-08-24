<?php

namespace App\Products\Services;

use App\Products\Interfaces\ProductVariantsRepositoryInterface;


use App\Products\Interfaces\VariantStockServiceInterface;

class VariantStockService implements VariantStockServiceInterface{


    public function __construct(
        protected readonly  ProductVariantsRepositoryInterface $product_variants_repository,
    ) {}

    public function UpdateStock($variant_id,$quantity) {
        $this->product_variants_repository->add_variant_stock_by_id($variant_id,$quantity);
    }

}