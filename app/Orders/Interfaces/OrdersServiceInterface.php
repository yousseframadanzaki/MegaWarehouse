<?php

namespace App\Orders\Interfaces;

interface OrdersServiceInterface{
    public function AddOrder($company_id,array $data);
    public function GetCompanyOrders($company_id,$filters);
    public function GetOrder($order_id);
    public function ChangeOrderStatus($order_id,$data);
    public function ChangeOrderStatusCallback($data);

}