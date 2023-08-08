<?php

namespace App\Orders\Repositories;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Status;

class OrdersRepository implements OrdersRepositoryInterface{
    
    public function create_order(array $data){
        $order_data = $data['client'];
        $order_data['client_id'] = $data['client_id'];
        $order_data['company_id'] = $data['company_id'];
        $order_data['admin_id'] = $data['admin_id'];
        $order_data['status_id'] = Status::where(['company_id'=>$data['company_id'],'default'=>true])->first()->id;
        $order_data['total'] = $this->calculate_total($data['items']);

        $order = Order::create($order_data);

        // dd($data['items']);

        $order->items()->sync($data['items']);

        return  $order;
    }

    function calculate_total($items) {
        $total = 0;
        foreach ($items as $id => $item) {
            $price = Variant::find($id)->value('price');
            $total += $price * (int)$item['quantity'];
        }
        return $total;
    }

    function add_items_to_order($order,$items) {
        $prepared_items = [];
        foreach ($items as $id => $value) {
            $prepared_items[$id] = ['value'=>$value];
        }
        dd($prepared_items);
        
    }

    public function get_company_orders($company_id){
        return Order::where(['company_id'=>$company_id])->paginate(20);
    }


}