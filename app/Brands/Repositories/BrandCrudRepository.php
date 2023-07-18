<?php

namespace App\Brands\Repositories;

use App\Models\Brand;
use App\Brands\Interfaces\BrandCrudRepositoryInterface;

class BrandCrudRepository implements BrandCrudRepositoryInterface{

    public function create_brand(array $details){
        return Brand::create($details);
    }

    public function update_brand($brand_id,array $details){
        return Brand::where(['id'=>$brand_id])->update($details);
    }

    public function get_brands_by_company_id($company_id){
        return Brand::with('logo')->where('company_id',$company_id)->paginate(10);
    }

    public function get_brand_by_id($id){
        return Brand::with('logo')->where('id', $id)->get()->first();
    }

}