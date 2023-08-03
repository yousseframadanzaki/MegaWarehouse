<?php

namespace App\Stock\Interfaces;

interface StockOperationRepositoryInterface
{
    public function create(array $details);
    public function get_operations_by_company_id($company_id,$filters);
}