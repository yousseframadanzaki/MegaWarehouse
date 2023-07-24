<?php

namespace App\Products\Repositories;

use App\Products\Interfaces\ProductAttributesRepositoryInterface;
use App\Models\Attribute;

class ProductAttributesRepository implements ProductAttributesRepositoryInterface{

    public function add_attributes($product_id,array $attributes){
        $prepared_attributes = $this->prepare_attributes($product_id,$attributes);
        Attribute::insert($prepared_attributes);
        return Attribute::where('product_id',$product_id)->pluck('id','name')->toArray();
    }

    private function prepare_attributes($product_id,array $attributes){
        $prepared = [];
        $index = 0;

        foreach ($attributes as $key => $value) {
            $prepared[$index]['name'] = $key;
            $prepared[$index]['values'] = json_encode($value);
            $prepared[$index]['product_id'] = $product_id;
            $index++;
        }

        return $prepared;

    }

}