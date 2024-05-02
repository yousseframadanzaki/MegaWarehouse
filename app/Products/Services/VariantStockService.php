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

    public function GetInvoiceInfo($variants_data){
        $data = array();
        $variants_ids = array_column($variants_data,'id');
        $variants = $this->product_variants_repository->get_variants($variants_ids);
        $total_cost = $this->calculate_total_cost($variants,$variants_data);

        $data['total_cost'] = $total_cost;
        $data['supplier_id'] = $variants[0]->product->supplier_id;
        $data['company_id'] = $variants[0]->product->company_id;

        // var_dump($data);die;

        return $data;

    }
    public function GetUnitValues($variants){
        $variants = $this->product_variants_repository->get_variants_unit_values($variants);
        return $variants;
    }

    private function calculate_total_cost($variants,$variants_data)
    {
        $total_cost = 0;
        $variants_data = array_combine(
            array_column($variants_data,'id'),
            array_column($variants_data,'quantity'),
        );

        foreach ($variants as $variant) {
           $total_cost += (float)$variant->product->cost * (int)$variants_data[$variant->id];
        }

        return $total_cost;
    }
    public function get_scan_items($ids)
    {
        $items = $this->product_variants_repository->get_scan_items($ids);
        return $items;
    }

}
