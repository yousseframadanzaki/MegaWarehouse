<?php

namespace App\ShippingCompanies\Interfaces;

interface ShippingCompanyServiceInterface{
    public function AddShippingCompany($company_id,$data);
    public function GetCompanyShippingCompanies($company_id);
    public function GetShippingCompany($shipping_company_id);
    public function UpdateShippingCompany($shipping_company_id,$data);
    public function SendShipment($order,$shipping_company_id);
    public function UpdateShipment($order,$shipping_company_id);
    public function SendShipmentV2($order,$shipping_company_id);
    public function Activate($shipping_company_id);
    public function Deactivate($shipping_company_id);
    public function GetShippingCompanyCalculations($shipping_company_id, $orders_filters);
}
