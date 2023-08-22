<?php

namespace App\Orders\Repositories;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Status;
use App\Models\Company;

class OrdersRepository implements OrdersRepositoryInterface{
    
    public function create_order(array $data){
        $order_data = $data['client'];
        $order_data['client_id'] = $data['client_id'];
        $order_data['company_id'] = $data['company_id'];
        $order_data['admin_id'] = $data['admin_id'];
        $order_data['order_code'] = $data['order_code'];
        $order_data['status_id'] = '1';
        $total_data = $this->calculate_total($data['items']);
        $order_data['total'] = $total_data['total'];
        $order_data['total_marketer_commission'] = $total_data['total_marketer_commission'];
        $order_data['marketer_id'] = $data['marketer_id'];

        $order = Order::create($order_data);

        $order->items()->sync($data['items']);
        $order->order_status()->sync([$order_data['status_id'] => ['admin_id' => $order_data['admin_id'],'note'=>'','current'=>true]]);

        return  $order;
    }

    function calculate_total($items) {
        $total = 0;
        $total_marketer_commission = 0;

        foreach ($items as $id => $item) {
            $variant = Variant::with('product')->find($id);
            $price = $variant->price;
            $commission = $variant->product->marketer_commission;

            $total += $price * (int)$item['quantity'];
            $total_marketer_commission += $commission * (int)$item['quantity'];
        }

        $data['total'] = $total;
        $data['total_marketer_commission'] = $total_marketer_commission;
        return $data;
    }

    public function get_company_orders($company_id,$filters){
        return Order::where(['company_id'=>$company_id])->filter($filters)->orderBy('created_at','DESC')->paginate(20);
    }

    public function get_order_code($company_id){
        $order_code  = Company::find($company_id)->code;
        $order_code .= Order::where('company_id',$company_id)->count() + 1;
        return $order_code;
    }

    public function get_order_by_id($order_id){
        return Order::with([
            'order_status',
            'admin',
            'items',
            'items.product',
            'client',
            'city',
            'area',
            'shipping_company',
            'marketer'])->where('id',$order_id)->first();
    }
    public function change_order_status($order_id,$data){
        $order = Order::findOrfail($order_id);
        $order->status_id = $data['status_id'];
        $order->save();
        $note = isset($data['note']) ? $data['note'] : '';

        $order->order_status()->newPivotStatement()->where(['order_id'=>$order_id,'current'=>true])->update(['current'=>false]);

        $order->order_status()->attach([
        $data['status_id'] => [
            'admin_id'=> (isset($data['admin_id']) ? $data['admin_id'] : NULL),
            'note'=> $note,
            'current'=> true,
        ]]);
        $id = $order->order_status()->get()[0]->pivot->id;
        return $id;
    }

    public function change_order_status_bulk($data)
    {
        $ids = array();
        foreach ($data['orders_ids'] as $id) {
            $ids[] =  $this->change_order_status($id,$data);
        }
        return $ids;
    }

    public function update_order($order_id,$data) {
        return Order::where('id',$order_id)->update($data);
    }

    
    public function get_order_by_waybill($waybill)
    {
        return Order::where(['waybill'=>$waybill])->first();
    }

}