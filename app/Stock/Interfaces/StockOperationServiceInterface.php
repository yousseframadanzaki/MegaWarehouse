<?php
namespace App\Stock\Interfaces;

interface StockOperationServiceInterface{

    public function CreateOperation($user,array $details);
    public function GetCompanyStock($company_id,$filters);
}