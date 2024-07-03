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
use App\Models\Status;
use App\Models\ShippingCompany;
use App\Models\Marketer;
use App\CommonData\Interfaces\CommonDataRepositoryInterface;
use App\Models\Order;
use App\Models\PaymentType;
use App\Policies\OrderPolicy;
use App\Policies\StockPolicy;

class CommonDataRepository implements CommonDataRepositoryInterface{
    protected $stockPolicy;
    protected $orderPolicy;

    public function __construct(stockPolicy $stockPolicy, orderPolicy $orderPolicy)
    {
        $this->stockPolicy = $stockPolicy;
        $this->orderPolicy = $orderPolicy;
    }

    public function get_roles_by_company_id($company_id){
        return Role::where('company_id',$company_id)->pluck('name','id');
    }

    public function get_roles_by_type($company_id,$user_type_id){
        return Role::where(['company_id'=>$company_id,'user_type_id'=>$user_type_id])->pluck('name','id');
    }

    public function get_categories_by_company_id($company_id){
        return Category::with('parents')->where('company_id',$company_id)->get();
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
            return Area::with('city')->get();
        }
        return Area::with('city')->where(['city_id'=>$city_id])->get();
    }

    public function get_company_warehouses($company_id){
        $user = auth()->user();
        if ($this->stockPolicy->view_his_quantity($user)){
            $warehouse = Warehouse::find($user->warehouse_id);
            return [$warehouse->id => $warehouse->name];
        }
        if ($this->orderPolicy->hide_quantity($user)){
            $warehouse = Warehouse::find($user->warehouse_id);
            return [$warehouse->id => $warehouse->name];
        }
        return Warehouse::where(['company_id'=>$company_id])->pluck('name','id');
    }

    public function get_company_products($company_id){
        return Product::where(['company_id'=>$company_id])->pluck('name','id');
    }

    public function get_company_products_data($company_id){
        return Product::where(['company_id'=>$company_id])->get();
    }

    public function get_product_variants($product_id, $is_bundle = 0){
        if ($is_bundle == 1) {
            $product = Product::find($product_id);
            $variants = $product->bundle_variants->map(function($item) use ($product) {
                $item['name']  = "( {$item->product->name} ) - ( $item->name )";
                $item['price'] = $item->pivot->price;
                $item['product'] = $product->first();
                return $item;
            });
        } else {
            $user = auth()->user();
            $variants = Variant::with('product')->where('product_id', $product_id)->get();
            $hide = $this->orderPolicy->hide_quantity($user) ? 1 : 0;
            $variants = $variants->map(function ($variant) use ($hide) {
                return array_merge($variant->toArray(), ['hide' => $hide]);
            });
        }
        return $variants;
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

    public function get_company_statuses(){
        return Status::all();
    }
    public function get_company_shipping_companies($company_id){
        return ShippingCompany::where(['active'=>true, 'company_id' => $company_id])->get();
    }

    public function get_company_marketers($company_id){
        return Marketer::all();
    }

    public function get_users_by_role_type($company_id,$role_type){
        return User::whereHas('role',function($query) use($role_type) {
            $query->where('user_type_id',$role_type);
        })->where(['company_id'=>$company_id])->get();
    }

    public function get_payment_types_categories(){
        return PaymentType::distinct()->pluck('category');
    }

    public function get_payment_types_by_category($category){
        return PaymentType::where('category', $category)->pluck('name', 'id');
    }
}
