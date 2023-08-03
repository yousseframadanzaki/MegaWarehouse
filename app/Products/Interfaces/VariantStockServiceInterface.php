<?php
namespace App\Products\Interfaces;

interface VariantStockServiceInterface{
    public function UpdateStock($variant_id,$quantity);
}