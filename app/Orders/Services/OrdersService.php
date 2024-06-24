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
        $data['shipping_company_id'] = $this->orders_crud_repository->get_shipping_company_id($order->area_id);
        $shipment = $this->ShippingCompanyService->SendShipmentV2($order,$data);
        if(!$shipment){
            return false;
        }
        $this->orders_crud_repository->update_order($order->id,
            array(
                'waybill'=>$shipment['waybill'],
                'shipping_company_id'=>$data['shipping_company_id'],
            )
        );
        if (!empty($note)) {
            $this->OrderNotesService->AddNote($order->id,$note,$user->id,$user->company_id);
        }
        $order_details['type'] = 'sell';
        $order_details['order_id'] = $order->id;

        $this->StockService->CreateOperation($user,$order_details);

        $this->CartService->EmptyCart();

        return true;

    }

    public function GetCompanyOrders($company_id,$filters) {
        return $this->orders_crud_repository->get_company_orders($company_id,$filters);
    }

    public function GetOrder($order_id){
        return $this->orders_crud_repository->get_order_by_id($order_id);
    }

    public function GetOrders($orders_ids){
        return $this->orders_crud_repository->get_orders_by_ids($orders_ids);
    }

    public function ChangeOrderStatus($order_id,$data){

        $order = $this->orders_crud_repository->get_order_by_id($order_id);

        if($data['status_id'] == '30'){
            $shipment = $this->ShippingCompanyService->SendShipment($order,$data['shipping_company_id']);

            if(!$shipment){
                return false;
            }
            $this->orders_crud_repository->update_order($order_id,
                array(
                    'waybill'=>$shipment['waybill'],
                    'shipping_company_id'=>$data['shipping_company_id'],
                )
            );
        } else if ($data['status_id'] == '45') {
            $this->TransactionService->AddTransaction(array(
                'order_id' => $order->id,
                'value' => $order->total_after_sale,
                'company_id' => $order->company_id,
                'commission' => $order->total_marketer_commission,
                'delivery_cost' => $order->delivery_cost,
                'payment_type_id' => 2,
            ));
        }

        $id = $this->orders_crud_repository->change_order_status($order_id,$data);

        if(isset($data['status_images'])){
            foreach ($data['status_images'] as $image) {
                $file = $this->FileUploadService->status($image,$data['company_id'],$id);
                $this->MediaService->save($file);
            }
        }
        return $id;
    }

    public function ChangeOrderStatusBulk($data)
    {
        if($data['status_id'] == '30'){
            foreach ($data['orders_ids'] as $order_id) {
                $order = $this->orders_crud_repository->get_order_by_id($order_id);
                $shipment = $this->ShippingCompanyService->SendShipment($order,$data['shipping_company_id']);

                if(!$shipment){
                    return false;
                }
                $this->orders_crud_repository->update_order($order_id,
                    array(
                        'waybill'=>$shipment['waybill'],
                        'shipping_company_id'=>$data['shipping_company_id'],
                    )
                );
            }
        } else if ($data['status_id'] == '45') {
            foreach ($data['orders_ids'] as $order_id) {
                $order = $this->orders_crud_repository->get_order_by_id($order_id);

                $this->TransactionService->AddTransaction(array(
                    'order_id' => $order->id,
                    'value' => $order->total_after_sale,
                    'company_id' => $order->company_id,
                    'commission' => $order->total_marketer_commission,
                    'delivery_cost' => $order->delivery_cost,
                    'payment_type_id' => 2,
                ));
            }
        }

        $ids =  $this->orders_crud_repository->change_order_status_bulk($data);
        if(isset($data['status_images'])){
            foreach ($data['status_images'] as $image) {
                $file = $this->FileUploadService->status($image,$data['company_id']);
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
    public function checkMaxOrders($company_id)
    {
        return $this->orders_crud_repository->check_max_orders($company_id);
    }
    public function GetOrderPrint($order_id ,$data)
    {
        return $this->orders_crud_repository->get_order_print($order_id ,$data);
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
    public function UpdateOrder($order_id ,$data)
    {
        return $this->orders_crud_repository->update_order($order_id ,$data);
    }
    public function UpdateStock($order_id, $data)
    {
        return $this->StockService->UpdateStock($order_id, $data);
    }
    public function AddStock($user, $order_id, $new_items)
    {
        if(!$this->checkMaxOrders($user->company_id)){
            return false;
        }

        if(!$this->StockService->CheckItemsAvailable($new_items)){
            return false;
        }

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
}

