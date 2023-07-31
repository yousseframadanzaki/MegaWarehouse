<?php

namespace App\Products\Interfaces;

interface ProductCrudServiceInterface{
    public function AddProduct($company_id,array $data);
    public function GetCompanyProducts($company_id);
    public function GetProduct($product_id);
    public function UpdateProduct($product_id,array $data);
}