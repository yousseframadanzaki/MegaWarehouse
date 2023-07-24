<?php

namespace App\Products\Repositories;

use App\Products\Interfaces\ProductCrudRepositoryInterface;
use App\Models\Product;

class ProductCrudRepository implements ProductCrudRepositoryInterface{

    public function add_product(array $product_details){
        return Product::create($product_details);
    }

    // public function get_company_products($company_id){
    //     return Product::where('company_id',$company_id)->paginate(10);
    // }

    // public function get_product_by_id($product_id){
    //     return Product::findOrFail($product_id);
    // }

    // public function update_product_by_id($product_id,array $product_details){
    //     return Product::where(['id'=>$product_id])->update($product_details);
    // }

}