<?php

namespace App\CommonData\Repositories;

use App\Models\Role;
use App\Models\Category;
use App\CommonData\Interfaces\CommonDataRepositoryInterface;

class CommonDataRepository implements CommonDataRepositoryInterface{
    
    public function get_roles_by_company_id($company_id){
        return Role::where('company_id',$company_id)->pluck('name','id');
    }
    
    public function get_categories_by_company_id($company_id){
        return Category::where('company_id',$company_id)->pluck('name','id');
    }
}