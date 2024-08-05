<?php

namespace App\Orders\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Clients\Interfaces\ClientCrudServiceInterface;
use App\Cart\Interfaces\CartServiceInterface;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\ShippingStatus\Interfaces\ShippingStatusServiceInterface;
use App\Products\Interfaces\VariantStockServiceInterface;
use App\OrderNotes\Interfaces\OrderNotesServiceInterface;
use App\Accounting\Interfaces\TransactionServiceInterface;

class OrdersService implements OrdersServiceInterface{

    public function __construct(
        protected readonly  ClientCrudServiceInterface $ClientCrudService,
        protected readonly  StockOperationServiceInterface $StockService,
        protected readonly  OrdersRepositoryInterface $orders_crud_repository,
        protected readonly  CartServiceInterface $CartService,
        protected readonly  UploadServiceInterface $FileUploadService,
        protected readonly  MediaCrudServiceInterface $MediaService,
        protected readonly  ShippingCompanyServiceInterface $ShippingCompanyService,
        protected readonly  ShippingStatusServiceInterface $ShippingStatusService,
        protected readonly VariantStockServiceInterface $VariantStockService,
        protected readonly OrderNotesServiceInterface $OrderNotesService,
        protected readonly TransactionServiceInterface $TransactionService,
    ) {}

    public function AddOrder($user,array $order_details){

        if(!$this->checkMaxOrders($user->company_id)){
            return false;
        }
        if(!$this->StockService->CheckItemsAvailable($order_details['items'])){
            $order_details['status_id'] = '5';
        }else{
            $order_details['status_id'] = '1';
        }

        $client = $this->ClientCrudService->GetClientByPhone($order_details['client']['phone_1']);
        if(empty($client)) {
            $client = $this->ClientCrudService->CreateClient($user->company_id,$order_details['client']);
        }
        $order_details['client_id'] = $client->id;
        $order_details['admin_id'] = $user->id;
        $order_details['company_id'] = $user->company_id;
        $order_details['order_code'] = $this->orders_crud_repository->get_order_code($user->company_id);
        $note = $order_details['client']['note'];
        unset($order_details['client']['note']);
        $order = $this->orders_crud_repository->create_order($order_details);
        if ($order_details['client_type'] != 'standard' || $order_details['service_type'] != 'تسليم و تحصيل')
        {
            $order->order_data()->create([
                'client_type' => $order_details['client_type'],
                'service_type' => $order_details['service_type'],
                'order_id' => $order->id,
            ]);
        }

        $shipping_company_id = $this->orders_crud_repository->get_shipping_company_id($order->area_id);
        $shipping_company = $this->ShippingCompanyService->GetShippingCompany($shipping_company_id);
        if($shipping_company->active == 1){
            $data['shipping_company_id'] = $shipping_company->id;
            $shipment = $this->ShippingCompanyService->SendShipment($order,$data);
            if(!$shipment){
                return false;
            }
            $this->orders_crud_repository->update_order($order->id,
                array(
                    'waybill'=>$shipment['waybill'],
                    'shipping_company_id'=>$data['shipping_company_id'],
                )
            );
        } else {
            $this->orders_crud_repository->update_order($order->id,
                array(
                    'shipping_company_id'=>$order->area->shipping_company_id,
                )
            );
        }

        if (!empty($note)) {
            $this->OrderNotesService->AddNote($order->id,$note,$user->id,$user->company_id);
        }

        $order_details['type'] = 'sell';
        $order_details['order_id'] = $order->id;

        $this->StockService->CreateOperation($user,$order_details);

        $this->CartService->EmptyCart();

        return $order;

    }

    public function GetCompanyOrders($company_id,$filters, $request = []) {
        return $this->orders_crud_repository->get_company_orders($company_id,$filters, $request);
    }

    public function GetOrder($order_id){
        return $this->orders_crud_repository->get_order_by_id($order_id);
    }

    public function GetOrders($orders_ids){
        return $this->orders_crud_repository->get_orders_by_ids($orders_ids);
    }

    public function ChangeOrderStatus($order_id,$data){
        // dd($data);
        $order = $this->orders_crud_repository->get_order_by_id($order_id);

        if($data['status_id'] == '30') {
            $shipping_company = $this->ShippingCompanyService->GetShippingCompany($data['shipping_company_id']);
            if ($shipping_company->active == 1) {
                if ($data['shipping_company_id'] == $order->area->shipping_company_id) {
                    $shipment = $this->ShippingCompanyService->UpdateShipment($order,$data['shipping_company_id']);
                } else {
                    $shipment = $this->ShippingCompanyService->SendShipmentV2($order,$data['shipping_company_id']);
                }

                if(!$shipment) {
                    return false;
                }
            }

            $this->orders_crud_repository->update_order($order_id,
                array(
                    'waybill'=> !empty($shipment['waybill']) ? $shipment['waybill'] : $order->waybill,
                    'shipping_company_id'=>$data['shipping_company_id'],
                )
            );
        } elseif ($data['status_id'] == '25') {
            $note = "محتوي الأوردر عند إلغاؤه نهائيا قبل الشحن <br>";
            foreach ($order->stocks as $stock) {
                $variant_name = $stock->variant->name;
                $product_name = ($stock->variant->product->name == $variant_name) ? '' : "( {$stock->variant->product->name} )";
                $quantity = abs($stock->quantity);
                $note .= "المنتج: {$product_name} {$variant_name} | الكمية: {$quantity} | السعر: {$stock->unit_price_after_sale} <br>";
            }
            $this->StockService->DeleteOperations($order->stocks->pluck('id'));
            $this->OrderNotesService->AddNote($order->id,$note,$data['admin_id'],$data['company_id']);
        } elseif ($data['status_id'] == '50') {
            $stocks = $order->stocks->where('type', 'sell');
            $flag = false;
            foreach ($data['variants'] as $index => $variant) {
                if ($variant['new_quantity'] != abs($stocks[$index]->quantity)) {
                    $flag = true;
                    break;
                }
            }
            if ($flag == false)
                return false;

            $note = "تفاصيل التسليم الجزئي <br>";
            $new_total = $order->total;
            $new_total_after_sale = $order->total_after_sale;
            foreach ($data['variants'] as $index => $variant) {
                $variant_name = $stocks[$index]->variant->name;
                $product_name = ($stocks[$index]->variant->product->name == $variant_name) ? '' : "( {$stocks[$index]->variant->product->name} )";
                $stock_quantity = abs($stocks[$index]->quantity);
                $note .= "المنتج {$product_name} {$variant_name}: تم تسليم {$variant['new_quantity']} من {$stock_quantity} <br>";
                $new_total -= ( ($stock_quantity - $variant['new_quantity']) * $stocks[$index]->unit_price );
                $new_total_after_sale -= ( ($stock_quantity - $variant['new_quantity']) * $stocks[$index]->unit_price_after_sale );
            }
            $note .= "المبلغ السابق: {$order->total_after_sale} و المبلغ الحالي: {$new_total_after_sale} <br>";
            $this->OrderNotesService->AddNote($order->id,$note,$data['admin_id'],$data['company_id']);
            $order->update([
                'total' => $new_total,
                'total_after_sale' => $new_total_after_sale,
            ]);
        } elseif($data['status_id'] == '85' && $order->stocks()->where('type', 'returned_orders')->limit(1)->count() == 0) {
            $details = ['type' => 'returned_orders', 'order_stocks' => $order->stocks];
            $this->StockService->CreateOperation(auth()->user(), $details);
        } elseif($data['status_id'] == '90' && $order->stocks()->where('type', 'returned_orders')->limit(1)->count() == 0) {
            $variants = collect($data['variants'])->filter(function ($item) {
                return $item['new_quantity'] > 0;
            })->values();

            $details = [
                'type' => 'returned_orders',
                'order_stocks' => $order->stocks->whereIn('variant_id', $variants->pluck('id'))->values(),
                'new_quantities' => $variants->pluck('new_quantity')
            ];
            $this->StockService->CreateOperation(auth()->user(), $details);
        }

        if ($this->orders_crud_repository->change_order_status($order_id,$data)){
            return true;
        }
    }

    public function ChangeOrderStatusBulk($data)
    {
        if ($data['status_id'] == '50' || $data['status_id'] == '90')
            return false;

        if($data['status_id'] == '30') {
            $shipping_company = $this->ShippingCompanyService->GetShippingCompany($data['shipping_company_id']);
            foreach ($data['orders_ids'] as $order_id) {
                $order = $this->orders_crud_repository->get_order_by_id($order_id);
                if ($shipping_company->active == 1) {
                    if ($data['shipping_company_id'] == $order->area->shipping_company_id) {
                        $shipment = $this->ShippingCompanyService->UpdateShipment($order,$data['shipping_company_id']);
                    } else {
                        $shipment = $this->ShippingCompanyService->SendShipmentV2($order,$data['shipping_company_id']);
                    }

                    if(!$shipment){
                        return false;
                    }
                }

                $this->orders_crud_repository->update_order($order_id,
                    array(
                        'waybill'=> !empty($shipment['waybill']) ? $shipment['waybill'] : $order->waybill,
                        'shipping_company_id'=>$data['shipping_company_id'],
                    )
                );
            }
        } elseif($data['status_id'] == '85') {
            foreach ($data['orders_ids'] as $order_id) {
                $order = $this->orders_crud_repository->get_order_by_id($order_id);
                if ($order->stocks()->where('type', 'returned_orders')->limit(1)->count() == 0) {
                    $details = array('type' => 'returned_orders', 'order_stocks' => $order->stocks);
                    $this->StockService->CreateOperation(auth()->user(), $details);
                }
            }
        } elseif ($data['status_id'] == '25') {
            foreach ($data['orders_ids'] as $order_id) {
                $order = $this->orders_crud_repository->get_order_by_id($order_id);
                $note = "محتوي الأوردر عند إلغاؤه نهائيا قبل الشحن <br>";
                foreach ($order->stocks as $stock) {
                    $variant_name = $stock->variant->name;
                    $product_name = ($stock->variant->product->name == $variant_name) ? '' : $stock->variant->product->name  . ' - ';
                    $quantity = abs($stock->quantity);
                    $note .= "المنتج: ( {$product_name} {$variant_name} ) | الكمية: {$quantity} | السعر: {$stock->unit_price_after_sale} <br>";
                }
                $this->StockService->DeleteOperations($order->stocks->pluck('id'));
                $this->OrderNotesService->AddNote($order->id,$note,$data['admin_id'],$data['company_id']);
            }
        }

        $ids =  $this->orders_crud_repository->change_order_status_bulk($data);
        if(isset($data['status_images'])){
            foreach ($data['status_images'] as $image) {
                $file = $this->FileUploadService->handle($image,'status',$data['company_id']);
                foreach ($ids as $id) {
                    $file->collection_id = $id;
                    $this->MediaService->save($file);
                }
            }
        }
        return $ids;
    }

    public function ChangeOrderStatusCallback($data){

        $order = $this->orders_crud_repository->get_order_by_waybill($data['waybill']);
        $status_id = $this->ShippingStatusService->GetStatusMapping($data['status_id'],$order->shipping_company_id);
        $note = $data['note'];
        // dd($status_id);
        if(empty($status_id) || empty($order->id)){
            return false;
        }

        $status_data = array(
            'status_id'=>$status_id,
            'note'=>$note,
        );
        $id = $this->orders_crud_repository->change_order_status($order->id,$status_data);
        if ($id && !empty($data['price'])) {
            $this->orders_crud_repository->update_order($order->id, ['total_after_sale' => $data['price']]);
            $note = "تم تغيير سعر إجمالي الاوردر بعد الخصم من {$order->total_after_sale} إلي {$data['price']}";
            $this->OrderNotesService->AddNote($order->id,$note,$order->shipping_company->user_id,$order->company_id);
        }
        return $id;
    }
    public function DeleteOrderStatusCallback($data){

        $order = $this->orders_crud_repository->get_order_by_waybill($data['waybill']);
        $status_id = $this->ShippingStatusService->GetStatusMapping($data['status_id'],$order->shipping_company_id);

        $status_data = array(
            'status_id'=>$status_id,
        );
        $id = $this->orders_crud_repository->delete_order_status($order->id,$status_data);
        return $id;
    }
    public function UpdateShippingCoCostCallback($data)
    {
        return $this->orders_crud_repository->update_shipping_co_cost($data);
    }
    public function SendOrderPaymentCallback($data){
        return $this->orders_crud_repository->send_order_payment($data);
    }
    public function checkMaxOrders($company_id)
    {
        return $this->orders_crud_repository->check_max_orders($company_id);
    }
    public function GetOrderPrint($order_id)
    {
        return $this->orders_crud_repository->get_order_print($order_id);
    }
    public function GetOrdersPrint($data)
    {
        return $this->orders_crud_repository->get_bulk_orders_print($data);
    }
    public function GetLabelPrint($order_id ,$data)
    {
        return $this->orders_crud_repository->get_order_print_label($order_id ,$data);
    }
    public function GetLabelsPrint($data)
    {
        return $this->orders_crud_repository->get_bulk_labels_print($data);
    }
    public function UpdateOrder($order_id, $data)
    {
        if(!$this->checkMaxOrders(auth()->user()->company_id)){
            return false;
        }

        $old_items = isset($data['old_items']) ? $data['old_items'] : array();
        $new_items = isset($data['items']) ? $data['items'] : array();

        if (!$this->StockService->CheckItemsAvailable(array_merge($old_items, $new_items))) {
            $data['client']['status_id'] = 5;
        }

        $this->UpdateStock($order_id, $old_items);
        $this->AddStock(auth()->user(), $order_id, $new_items);

        return $this->orders_crud_repository->update_order($order_id, $data['client']);
    }
    public function UpdateStock($order_id, $data)
    {
        return $this->StockService->UpdateStock($order_id, $data);
    }
    public function AddStock($user, $order_id, $new_items)
    {
        foreach ($new_items as &$item) {
            $item['admin_id'] = $user->id;
            $item['company_id'] = $user->company_id;
            $item['type'] = 'sell';
            $item['order_id'] = $order_id;
            $variants = $this->VariantStockService->GetUnitValues([$item['id']]);
            foreach ($variants as $variant) {
                $item['unit_commission'] = $variant->product->marketer_commission;
                $item['unit_cost'] = $variant->product->cost;
            }
        }
        return $this->StockService->AddStock($new_items);
    }
    // public function DeleteOrder($variant_id)
    // {
    //     return $this->orders_crud_repository->DeleteOrder($variant_id);
    // }
    public function get_scan_items($ids)
    {
        return $this->VariantStockService->get_scan_items($ids);
    }
    public function UpdateAfterSaleOrder($id,$company_id,$data){
        return $this->orders_crud_repository->update_after_sale($id,$company_id,$data);
    }
    public function SearchOrders($company_id, $data) {
        return $this->orders_crud_repository->search_orders($company_id, $data);
    }
    public function DeleteOrder($order_id) {
        return $this->orders_crud_repository->delete_order($order_id);
    }
    public function UpdateIncompleteOrdersStatus() {
        return $this->orders_crud_repository->update_incomplete_orders_status();
    }
}

