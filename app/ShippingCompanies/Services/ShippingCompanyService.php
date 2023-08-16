<?php

namespace App\ShippingCompanies\Services;

use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;

class ShippingCompanyService implements ShippingCompanyServiceInterface{


    public function __construct(
        protected readonly ShippingCompanyRepositoryInterface $shipping_company_repository
    ) {}

    public function AddShippingCompany($company_id,$data){
        // TODO here we will check company url is valid

        $data['company_id'] = $company_id;
        return $this->shipping_company_repository->create_shipping_company($data);
    }

}