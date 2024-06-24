<?php

namespace App\Products\Interfaces;

interface ProductCrudServiceInterface{
    public function AddProduct($company_id,array $data);
    public function GetCompanyProducts($company_id,$filters);
    public function GetProduct($product_id);
    public function UpdateProduct($product_id,array $data);
    public function GetVariantPrint($variant_id);
    public function GetBulkVariantsPrint(array $variants_ids);
    public function AddPackage($company_id,array $data);
    public function DeleteProduct($product_id);
    public function DeleteVariant($variant_id, $is_bundle);
}
