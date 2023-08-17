<?php

namespace App\ShippingCompanies\Services;

use App\ShippingCompanies\Interfaces\ShippingCompanyRepositoryInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;

use App\MegaAPI\Interfaces\MegaApiServiceInterface;

class ShippingCompanyService implements ShippingCompanyServiceInterface{


    public function __construct(
        protected readonly ShippingCompanyRepositoryInterface $shipping_company_repository,
        protected readonly MegaApiServiceInterface $MegaApiService
    ) {}

    public function AddShippingCompany($company_id,$data){
        // $data['mega_company_id'] = $this->MegaApiService
        //     ->GetMegaCompanyId(
        //         $data['username'],
        //         $data['password'],
        //         $data['url']
        //     );
        $data['mega_company_id'] = '1';
        if(empty($data['mega_company_id'])){
            return false;
        }
        $data['company_id'] = $company_id;
        return $this->shipping_company_repository->create_shipping_company($data);
    }

    public function GetCompanyShippingCompanies($company_id){
        return $this->shipping_company_repository->get_shipping_companies_by_company_id($company_id);
    }
    public function GetShippingCompany($shipping_company_id){
        return $this->shipping_company_repository->get_shipping_company_by_id($shipping_company_id);
    }
    public function UpdateShippingCompany($shipping_company_id,$data){
        // $data['mega_company_id'] = $this->MegaApiService
        //     ->GetMegaCompanyId(
        //         $data['username'],
        //         $data['password'],
        //         $data['url']
        //     );
        $data['mega_company_id'] = '1';
        if(empty($data['mega_company_id'])){
            return false;
        }
        return $this->shipping_company_repository->update_shipping_company_by_id($shipping_company_id,$data);
    }
}