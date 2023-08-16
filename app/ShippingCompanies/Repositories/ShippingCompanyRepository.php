<?php

namespace App\ShippingCompanies\Repositories;

use App\Models\ShippingCompany;
use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;

class ShippingCompanyRepository implements ShippingCompanyRepositoryInterface{

    public function create_shipping_company($data){
        return ShippingCompany::create($data);
    }

}