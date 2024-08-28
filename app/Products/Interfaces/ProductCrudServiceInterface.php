<?php

namespace App\Products\Interfaces;

interface ProductCrudServiceInterface{
    public function AddProduct($company_id,array $data);
    public function GetCompanyProducts($company_id,$filters);
    public function GetProduct($product_id);
    public function UpdateProduct($product_id,array $data);
    public function UpdateVariant($variant_id,array $data);
    public function GetVariantPrint($variant_id);
    public function GetBulkVariantsData(array $variants_ids);
    public function AddPackage($company_id,array $data);
    public function DeleteProduct($product_id);
    public function DeleteVariant($variant_id, $is_bundle);
    public function GetVariantShelfData(array $data);
    public function IncompleteOrdersVariants($company_id);
    public function GetAllVariants($page);
    public function GetVariantsByOrders(array $order_ids);
}
