<?php

namespace App\Stock\Repositories;

use App\Stock\Interfaces\StockOperationRepositoryInterface;
use App\Models\Stock;
use App\Models\Variant;
use App\Policies\StockPolicy;
use App\Policies\OrderPolicy;

class StockOperationRepository implements StockOperationRepositoryInterface{
    protected $stockPolicy;
    protected $orderPolicy;

    public function __construct(stockPolicy $stockPolicy, orderPolicy $orderPolicy)
    {
        $this->stockPolicy = $stockPolicy;
        $this->orderPolicy = $orderPolicy;
    }

    public function create($operation) {
        $stock = Stock::create($operation);
        return $stock->id;
    }

    public function get_operations_by_company_id($company_id,$filters) {
        return Stock::with([
            'order',
            'warehouse',
            'admin',
            'variant',
            'image',
            'variant.product',
            'variant.product.supplier',
        ])->where(['company_id'=>$company_id])
        ->filter($filters)
        ->orderBy('created_at','DESC')
        ->paginate(20);
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
    public function get_variant_stock_warehouse($variant_id,$user) {
        if ($this->stockPolicy->view_his_quantity($user)) {
            return Stock::with(
                ['warehouse' => function ($query) {
                    $query->select('id', 'name');
                }]
            )
            ->groupBy('warehouse_id')
            ->where('variant_id',$variant_id)
            ->where('warehouse_id', $user->warehouse_id)
            ->selectRaw('sum(quantity) as sum, warehouse_id')
            ->get();
        } else {
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
        if ($this->orderPolicy->hide_quantity($user)) {
            return Stock::with(
                ['warehouse' => function ($query) {
                    $query->select('id', 'name');
                }]
            )
            ->groupBy('warehouse_id')
            ->where('variant_id',$variant_id)
            ->where('warehouse_id', $user->warehouse_id)
            ->selectRaw('sum(quantity) as sum, warehouse_id')
            ->get();
        } else {
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
    public function get_variant_stock_by_warehouse_id($variant_id,$warehouse_id) {
        return Stock::where([
            'variant_id'=>$variant_id,
            'warehouse_id'=>$warehouse_id
            ])
        ->selectRaw('sum(quantity) as sum')
        ->value('sum');
    }

    public function update_invoice_id($ids,$invoice_id) {
        return Stock::whereIn('id',$ids)->update(['invoice_id'=>$invoice_id]);
    }
    public function update_stock($order_id ,$data){
        foreach ($data as $index => $stockData) {
            Stock::where('order_id', $order_id)
                 ->where('variant_id', $stockData['id'])
                 ->update([
                     'unit_price_after_sale' => $stockData['unit_sale'],
                     'warehouse_id' => $stockData['warehouse_id'],
                     'quantity' => $stockData['quantity'],
                     'updated_at' => now()
                 ]);
        }
        return true;
    }
    public function AddStock($new_items){
        $new_stocks = [];
        foreach ($new_items as $item) {
            $item['variant_id'] = $item['id'];
            unset($item['id']);
            $new_stock = Stock::create($item);
            $new_stocks[] = $new_stock;
        }
        return $new_stocks;
    }
    public function DeleteStock($variant_id){
        return Stock::where('variant_id', $variant_id)->delete();
        return true;
    }

}
