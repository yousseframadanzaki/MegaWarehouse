<?php

namespace App\Stock\Interfaces;

interface StockOperationRepositoryInterface
{
    public function create(array $details);
    public function get_operations_by_company_id($company_id,$filters);
    public function get_variant_stock_by_warehouse_id($variant_id,$warehouse_id);
}