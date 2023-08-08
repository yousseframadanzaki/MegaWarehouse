<?php

namespace App\Orders\Interfaces;

interface OrdersServiceInterface{
    public function AddOrder($company_id,array $data);
    public function GetCompanyOrders($company_id);
    // public function GetCompanyOrders($company_id,$filters);
}