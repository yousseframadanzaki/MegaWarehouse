<?php

namespace App\Orders\Repositories;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Company;
use App\Models\OrderStatus;
use App\Models\OrderNotes;
use App\Models\Area;
use App\Models\Stock;

class OrdersRepository implements OrdersRepositoryInterface{

    public function create_order(array $data){
        $order_data = $data['client'];
        $order_data['client_id'] = $data['client_id'];
        $order_data['company_id'] = $data['company_id'];
        $order_data['admin_id'] = $data['admin_id'];
        $order_data['order_code'] = $data['order_code'];
        $order_data['status_id'] = $data['status_id'];

        $total_data = $this->calculate_total($data['items'],$order_data['client_id']);
        $total_after_sale = $this->calculate_total_after_sale($data['items']);

        $order_data['total'] = ($total_data['total'] + $order_data['delivery_cost']);
        $order_data['total_after_sale'] = ($total_after_sale + $order_data['delivery_cost']);
        $order_data['total_marketer_commission'] = $total_data['total_marketer_commission'];
        $order_data['marketer_id'] = $data['marketer_id'];
        $sale_note = $order_data['total'] - $order_data['total_after_sale'];
        $order = Order::create($order_data);

        if ($sale_note > 0) {
            $note = 'تم اضافة خصم على الأوردر (اجمالى الخصم ' . $sale_note . ')';
            $this->add_order_note($order->id,$note,$data['admin_id'],$data['company_id']);
        }

        // $order->items()->sync($data['items']);
        $order->order_status()->sync([$order_data['status_id'] => ['admin_id' => $order_data['admin_id'],'note'=>'','current'=>true]]);

        return  $order;
    }
    function calculate_total_after_sale($items){
        $total = 0;
        foreach ($items as $item) {
            $total += intval($item['unit_sale']) * intval($item['quantity']);
        }
        return $total;
    }
    function calculate_total($items,$client_id) {
        $total = 0;
        $total_marketer_commission = 0;
        foreach ($items as $item) {
            $variant = Variant::with('product')->find($item['id']);
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
        return Order::with(['marketer','admin','status','city','area','order_notes', 'order_data'])->where(['company_id'=>$company_id])->filter($filters)->orderBy('created_at','DESC')->paginate(50);
    }

    public function get_order_code($company_id){
        $order_code  = Company::find($company_id)->code;
        $order_code .= Order::where('company_id',$company_id)->count() + 1;
        return $order_code;
    }

    public function get_order_by_id($order_id){
        return Order::with([
            'order_status',
            'order_data',
            'order_status.pivot.admin',
            'order_status.pivot.images',
            'admin',
            'stocks',
            'stocks.variant',
            'stocks.variant.product',
            'stocks.warehouse',
            'client',
            'city',
            'area',
            'shipping_company',
            'marketer'])->where('id',$order_id)->first();
    }
    public function get_orders_by_ids($orders_ids) {
        return Order::with([
            'order_status',
            'order_data',
            'order_status.pivot.admin',
            'order_status.pivot.images',
            'admin',
            'stocks',
            'stocks.variant',
            'stocks.variant.product',
            'stocks.warehouse',
            'client',
            'city',
            'area',
            'shipping_company',
            'marketer'])->whereIn('id',$orders_ids)->get();
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
   public function delete_order_status($order_id,$data){
        $status = OrderStatus::where('order_id', $order_id)
                    ->where('status_id', $data['status_id'])
                    ->firstOrFail();
        $status->delete();

        $previous_status = OrderStatus::where('order_id', $order_id)->latest()->firstOrFail();
        $previous_status->update([
            'current' => 1
        ]);

        Order::findOrFail($order_id)->update([
            'status_id' => $previous_status->status_id
        ]);
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
        if (isset($data['total'])) {
            $total = str_replace(',', '', $data['total']);
            $data['total'] = $total + $data['delivery_cost'];
        }
        if (isset($data['total_after_sale'])) {
            $total_after_sale = str_replace(',', '', $data['total_after_sale']);
            $data['total_after_sale'] =  $total_after_sale + $data['delivery_cost'];
        }
        return Order::where('id',$order_id)->update($data);
    }
    public function check_max_orders($company_id)
    {
        $company = Company::find($company_id);
        $max_orders = $company->max_orders;
        $current_orders = Order::where(['company_id'=>$company_id])->count();
        if($current_orders + 1 > $max_orders){
            return false;
        }
        return true;
    }

    public function get_order_by_waybill($waybill)
    {
        return Order::where(['waybill'=>$waybill])->first();
    }
    public function get_order_print($data ,$order_id) {
        $orders = [];
        $order = Order::with(['stocks','stocks.variant','stocks.variant.product','companies'])->find($order_id);
        $orders[] = $order;
        return $orders;
    }
    public function get_bulk_orders_print($data) {
        $orders = [];
        foreach ($data['orders_ids'] as $order_id) {
            $order = Order::with(['stocks','stocks.variant','stocks.variant.product'])->find($order_id);

            if ($order) {
                $orders[] = $order;
            }
        }
        return $orders;
    }
    public function get_order_print_label($data ,$order_id)
    {
        $orders = [];
        $order = Order::find($order_id);
        $orders[] = $order;
        return $orders;
    }
    public function get_bulk_labels_print($data) {
        //var_dump($data);die;
        $orders = [];
        foreach ($data['orders_labels_ids'] as $order_id) {
            $order = Order::find($order_id);

            if ($order) {
                $orders[] = $order;
            }
        }
        return $orders;
    }
    public function add_order_note($order_id,$note,$admin_id,$company_id){
        $order_note = new OrderNotes;
        $order_note->order_id = $order_id;
        $order_note->note = $note;
        $order_note->admin_id = $admin_id;
        $order_note->company_id = $company_id;
        return $order_note->save();
    }
    public function update_after_sale($id,$company_id,$data){
        $order = Order::where('id', $id)->where('company_id', $company_id)->first();
        $order->update($data);
    }
    public function search_orders($company_id, $data) {
        return Order::with(['marketer','admin','status','city','area','order_notes'])->where('company_id', $company_id)->where(function($query) use ($data) {
            $query->whereIn('order_code', $data)->orWhereIn('waybill', $data);
        })->paginate(50);
    }
    public function delete_order($order_id)
    {
        $order = Order::findOrFail($order_id);
        if ($order->status_id != 45)
            Stock::where('order_id', $order->id)->delete();

        OrderNotes::where('order_id', $order->id)->delete();
        $deleted = $order->delete();
        return $deleted;
    }
    public function get_shipping_company_id($area_id){
        $area = Area::find($area_id);
        return $area->shipping_company_id;
    }
}
