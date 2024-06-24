<?php

namespace App\Products\Repositories;

use App\Products\Interfaces\ProductCrudRepositoryInterface;
use App\Models\Product;
use App\Policies\StockPolicy;


class ProductCrudRepository implements ProductCrudRepositoryInterface{
    protected $stockPolicy;

    public function __construct(stockPolicy $stockPolicy)
    {
        $this->stockPolicy = $stockPolicy;
    }

    public function add_product(array $product_details){
        return Product::create($product_details);
    }
    public function get_products_by_company_id($company_id,$filters){
        return Product::with(['main_image','category','brand','supplier'])
        ->where('company_id',$company_id)
        ->orderBy('id', 'desc')
        ->filter($filters)
        ->paginate(10);
    }

    public function get_product_by_id($product_id){
        $user = auth()->user();
        if ($this->stockPolicy->view_his_quantity($user)) {
        $warehouse_id = $user->warehouse_id;
        $product = Product::with([
            'attributes',
            'variants',
            'variants.stock' => function($query) use ($warehouse_id) {
                $query->where('warehouse_id', $warehouse_id);
            },
            'main_image',
            'images',
            'category',
            'supplier',
            'brand'
        ])->findOrFail($product_id);

        foreach ($product->variants as $variant) {
            $buyQuantity = $variant->stock
                ->where('warehouse_id', $warehouse_id)
                ->sum('quantity');

            $totalStockQuantity = $buyQuantity;
            $variant->total_stock_quantity = $totalStockQuantity >= 0 ? $totalStockQuantity : 0;
        }
        return $product;
        } else {
            $product = Product::with([
                'attributes',
                'variants',
                'variants.stock',
                'main_image',
                'images',
                'category',
                'supplier',
                'brand'
            ])->findOrFail($product_id);

            foreach ($product->variants as $variant) {
                $buyQuantity = $variant->quantity;
                $totalStockQuantity = $buyQuantity;
                $variant->total_stock_quantity = $totalStockQuantity >= 0 ? $totalStockQuantity : 0;
            }
            return $product;
        }
    }

    // public function get_company_products($company_id){
    //     return Product::where('company_id',$company_id)->paginate(10);
    // }

    // public function get_product_by_id($product_id){
    //     return Product::findOrFail($product_id);
    // }


    public function update_product_by_id($product_id,array $product_details){
        return Product::where(['id'=>$product_id])->update($product_details);
    }

    public function delete_product($product_id) {
        return Product::find($product_id)->delete();
    }
}
