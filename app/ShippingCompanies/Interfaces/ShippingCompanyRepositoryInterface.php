<?php

namespace App\ShippingCompanies\Interfaces;

interface ShippingCompanyRepositoryInterface{

    public function create_shipping_company($data);
    public function get_shipping_companies_by_company_id($company_id);
    public function get_shipping_company_by_id($id);
    public function update_shipping_company_by_id($id,$data);

}