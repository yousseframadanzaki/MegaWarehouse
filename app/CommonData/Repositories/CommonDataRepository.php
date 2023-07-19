<?php

namespace App\CommonData\Repositories;

use App\Models\Role;
use App\Models\Category;
use App\Models\ClientGroup;
use App\Models\Country;
use App\Models\City;
use App\Models\Area;
use App\CommonData\Interfaces\CommonDataRepositoryInterface;

class CommonDataRepository implements CommonDataRepositoryInterface{
    
    public function get_roles_by_company_id($company_id){
        return Role::where('company_id',$company_id)->pluck('name','id');
    }
    
    public function get_categories_by_company_id($company_id){
        return Category::where('company_id',$company_id)->pluck('name','id');
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
    
}