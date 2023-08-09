<?php

namespace App\Orders\Interfaces;

interface OrdersRepositoryInterface{
    public function create_order(array $data);
    public function get_company_orders($company_id,$filters);
}