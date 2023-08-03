<?php

namespace App\Stock\Repositories;

use App\Stock\Interfaces\StockOperationRepositoryInterface;
use App\Models\Stock;

class StockOperationRepository implements StockOperationRepositoryInterface{

    public function create($operation) {
        $stock = Stock::create($operation);
        return $stock->id;
    }
    
    public function get_operations_by_company_id($company_id,$filters) {
        return Stock::where(['company_id'=>$company_id])->filter($filters)->paginate(10);
    }

}