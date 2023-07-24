<?php

namespace App\Products\Repositories;

use App\Products\Interfaces\ProductVariantsRepositoryInterface;
use App\Models\Variant;

class ProductVariantsRepository implements ProductVariantsRepositoryInterface{

    public function add_default_variant(array $product){
        $variant = new Variant();
        $variant->name = $product->name;
        $variant->price = $product->price;
        $variant->is_default = true;
        $variant->product_id = $product->id;
        $variant->save();
        return $variant;
    }

    public function add_variants($product_id,$attributes,$variants){
      foreach ($variants as $variant) {
        $variant_info = $this->array_exclude($variant,['options']);
        $variant_info['product_id'] = $product_id;
        $created_variant = Variant::create($variant_info);
        $prepared_attributes = $this->prepare_attributes($variant['options'],$attributes);
        // dd($prepared_attributes);
        $created_variant->attributes()->sync($prepared_attributes);
      }
    }


    public function prepare_attributes($options,$attributes_ids) {
        $prepared_attributes = [];
        foreach ($options as $key => $value) {
            $prepared_attributes[$attributes_ids[$key]] = ['value' => $value];
        }
        return $prepared_attributes;
    }

    function array_exclude($array, Array $excludeKeys){
        foreach($excludeKeys as $key){
            unset($array[$key]);
        }
        return $array;
    }

    public function prepare_data($product_id,$attributes,$variants) {
        
    }

}