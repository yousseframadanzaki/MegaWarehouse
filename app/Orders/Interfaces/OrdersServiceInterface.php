<?php

namespace App\Orders\Interfaces;

interface OrdersServiceInterface{
    public function AddOrder($user ,array $data);
    public function GetCompanyOrders($company_id,$filters);
    public function GetOrder($order_id);
    public function GetOrders($orders_ids);
    public function ChangeOrderStatus($order_id,$data);
    public function ChangeOrderStatusCallback($data);
    public function DeleteOrderStatusCallback($data);
    public function UpdateOrder($order_id,$data);
    public function AddStock($user ,$order_id ,$new_items);
    public function get_scan_items($ids);
    public function UpdateAfterSaleOrder($id,$company_id,$data);
    public function SearchOrders($company_id, array $data);
    public function DeleteOrder($order_id);
    public function UpdateShippingCoCostCallback(array $data);
}
