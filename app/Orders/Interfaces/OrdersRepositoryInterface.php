<?php

namespace App\Orders\Interfaces;

interface OrdersRepositoryInterface{
    public function create_order(array $data);
    public function get_company_orders($company_id,$filters);
    public function get_order_code($company_id);
    public function get_order_by_id($order_id);
    public function change_order_status($order_id,$data);
    public function get_order_by_waybill($waybill);
    public function check_max_orders($company_id);
}