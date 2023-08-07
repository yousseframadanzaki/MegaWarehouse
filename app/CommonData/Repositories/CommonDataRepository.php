<?php

namespace App\CommonData\Repositories;

use App\Models\Role;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Brand;
use App\Models\ClientGroup;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\Models\Warehouse;
use App\Models\Product;
use App\Models\Variant;
use App\Models\User;
use App\Models\Client;
use App\Models\Attribute;
use App\CommonData\Interfaces\CommonDataRepositoryInterface;

class CommonDataRepository implements CommonDataRepositoryInterface{
    
    public function get_roles_by_company_id($company_id){
        return Role::where('company_id',$company_id)->pluck('name','id');
    }
    
    public function get_categories_by_company_id($company_id){
        return Category::where('company_id',$company_id)->get();
    }

    public function get_suppliers_by_company_id($company_id){
        return Supplier::where('company_id',$company_id)->pluck('name','id');
    }

    public function get_brands_by_company_id($company_id){
        return Brand::where('company_id',$company_id)->pluck('name','id');
    }
    
    public function get_sub_categories($category_id){
        return Category::where(['parent_id'=>$category_id])->pluck('name','id');
    }

    public function get_client_groups_by_company_id($company_id){
        return ClientGroup::where('company_id',$company_id)->pluck('name','id');
    }

    public function get_countries(){
        return Country::all()->pluck('name','id');
    }

    public function get_cities($country_id=NULL){
        if($country_id==NULL){
            return City::all()->pluck('name','id');
        }
        return City::where(['country_id'=>$country_id])->pluck('name','id');
    }

    public function get_areas($city_id=NULL){
        if($city_id==NULL){
            return Area::all()->pluck('name','id');
        }
        return Area::where(['city_id'=>$city_id])->pluck('name','id');
    }

    public function get_company_warehouses($company_id){
        return Warehouse::where(['company_id'=>$company_id])->pluck('name','id');
    }

    public function get_company_products($company_id){
        return Product::where(['company_id'=>$company_id])->pluck('name','id');
    }

    public function get_product_variants($product_id){
        return Variant::where(['product_id'=>$product_id])->get();
    }

    public function get_company_users($company_id){
        return User::where(['company_id'=>$company_id])->pluck('name','id');
    }

    public function get_company_clients($company_id){
        return Client::where(['company_id'=>$company_id])->get();
    }

    public function get_product_attributes($product_id){
        return Attribute::where(['product_id'=>$product_id])->get();
    }

    public function get_variant_by_id($variant_id){
        return Variant::with('product')->where(['id'=>$variant_id])->first();
    }
    
}