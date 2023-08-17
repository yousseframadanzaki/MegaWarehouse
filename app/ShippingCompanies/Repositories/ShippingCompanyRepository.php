<?php

namespace App\ShippingCompanies\Repositories;

use App\Models\ShippingCompany;
use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;

class ShippingCompanyRepository implements ShippingCompanyRepositoryInterface{

    public function create_shipping_company($data){
        return ShippingCompany::create($data);
    }

    public function get_shipping_companies_by_company_id($company_id){
        return ShippingCompany::where(['company_id'=>$company_id])->get();
    }
    public function get_shipping_company_by_id($id){
        return ShippingCompany::findOrFail($id);
    }
    public function update_shipping_company_by_id($id,$data){
        return ShippingCompany::where(['id'=>$id])->update($data);
    }
}