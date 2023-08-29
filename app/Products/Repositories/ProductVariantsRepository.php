<?php

namespace App\Products\Repositories;

use App\Products\Interfaces\ProductVariantsRepositoryInterface;
use App\Models\Variant;

class ProductVariantsRepository implements ProductVariantsRepositoryInterface{

    public function add_default_variant($product){
        $variant = new Variant();
        $variant->name = $product->name;
        $variant->price = $product->price;
        $variant->is_default = true;
        $variant->product_id = $product->id;
        $variant->save();
        $variant->sku = $product->id . '-' . $variant->id;
        $variant->save();
        return $variant;
    }

    public function add_variants($product,$attributes,$variants){
      foreach ($variants as $variant) {
        $variant_info = $this->array_exclude($variant,['options']);
        $variant_info['product_id'] = $product->id;
        if(!isset($variant_info['price'])){
            $variant_info['price'] = $product->price;
        }
        $created_variant = Variant::create($variant_info);
        if(empty($variant_info['sku'])){
            $variant_info['sku'] = implode("-",array_values($attributes));
            $variant_info['sku'] = $product->id .'-'. $created_variant->id ."-" . $variant_info['sku'];
            $created_variant->sku = $variant_info['sku'];
            $created_variant->save();
        }
        $prepared_attributes = $this->prepare_attributes($variant['options'],$attributes);
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

    public function get_variant_by_id($variant_id){
        return Variant::with('product','attributes')->where('id',$variant_id)->first();
    }

    public function get_variant_by_id_no_relations($variant_id){
        return Variant::where('id',$variant_id)->first();
    }

    public function update_variant_by_id($variant_id,$data){
        return Variant::where('id',$variant_id)->update($data);
    }

    public function add_variant_stock_by_id($variant_id,$quantity){
        return Variant::where('id',$variant_id)->increment('quantity',$quantity);
    }
    public function get_variants($variants_ids){
        return Variant::with('product')->whereIn('id',$variants_ids)->get();
    }

    public function get_variants_unit_values($variants_ids){
        return Variant::with(['product' => function ($query) {
            $query->select('id', 'cost','marketer_commission');
        }])
        ->whereIn('id',$variants_ids)
        ->get();
        
    }

}