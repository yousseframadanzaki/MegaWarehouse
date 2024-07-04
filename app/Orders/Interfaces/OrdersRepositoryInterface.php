<?php

namespace App\Orders\Interfaces;

interface OrdersRepositoryInterface{
    public function create_order(array $data);
    public function get_company_orders($company_id,$filters);
    public function get_order_code($company_id);
    public function get_order_by_id($order_id);
    public function get_orders_by_ids($orders_ids);
    public function change_order_status($order_id,$data);
    public function delete_order_status($order_id,$status_data);
    public function get_order_by_waybill($waybill);
    public function check_max_orders($company_id);
    public function update_order($order_id,$data);
    public function update_after_sale($id,$company_id,$data);
    public function search_orders($company_id, array $data);
    public function delete_order($order_id);
    public function get_shipping_company_id($area_id);
    public function update_shipping_co_cost(array $data);
}
