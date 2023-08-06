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
        return Stock::where(['company_id'=>$company_id])->filter($filters)->orderBy('created_at','DESC')->paginate(20);
    }

    public function get_variant_stock_in_warehouse($variant_id,$warehouse_id){
        return Stock::where(['variant_id'=>$variant_id,'warehouse_id'=>$warehouse_id])->sum('quantity');
    }

    public function get_operation_by_id($id){
        return Stock::where(['id'=>$id])->first();
    }

    public function delete_operation_by_id($id){
        return Stock::destroy($id);
    }
    public function get_variant_stock_warehouse($variant_id) {
        return Stock::with(
            ['warehouse' => function ($query) {
                $query->select('id', 'name');
            }]
        )
        ->groupBy('warehouse_id')
        ->where('variant_id',$variant_id)
        ->selectRaw('sum(quantity) as sum, warehouse_id')
        ->get();
    }
}