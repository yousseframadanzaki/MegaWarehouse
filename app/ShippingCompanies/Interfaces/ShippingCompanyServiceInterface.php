<?php

namespace App\ShippingCompanies\Interfaces;

interface ShippingCompanyServiceInterface{

    public function AddShippingCompany($company_id,$data);
    public function GetCompanyShippingCompanies($company_id);
    public function GetShippingCompany($shipping_company_id);
    public function UpdateShippingCompany($shipping_company_id,$data);
    public function SendShipment($order,$shipping_company_id);

}