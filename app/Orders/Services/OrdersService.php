<?php

namespace App\Orders\Services;

use App\FileUpload\Interfaces\UploadServiceInterface;
use App\Media\Interfaces\MediaCrudServiceInterface;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Clients\Interfaces\ClientCrudServiceInterface;

class OrdersService implements OrdersServiceInterface{

    public function __construct(
        protected readonly  ClientCrudServiceInterface $ClientCrudService,
        protected readonly  StockOperationServiceInterface $StockService,
        protected readonly  OrdersRepositoryInterface $orders_crud_repository,
        protected readonly  UploadServiceInterface $FileUploadService,
        protected readonly  MediaCrudServiceInterface $MediaService,
    ) {}

    public function AddOrder($user,array $order_details){
        if(!$this->StockService->CheckItemsAvailable($order_details['items'])){
            return false;
        }

        if(!isset($order_details['client_id'])){
            $client = $this->ClientCrudService->CreateClient($user->company_id,$order_details['client']);
            $order_details['client_id'] = $client->id;
        }
        // dd('stop');
        $order_details['admin_id'] = $user->id;
        $order_details['company_id'] = $user->company_id;
        $order_details['order_code'] = $this->orders_crud_repository->get_order_code($user->company_id);
        $order = $this->orders_crud_repository->create_order($order_details);
        // dd($order);
        $order_details['type'] = 'sell';
        $order_details['order_id'] = $order->id;

        $this->StockService->CreateOperation($user,$order_details);

        return true;

    }

    public function GetCompanyOrders($company_id,$filters) {
        return $this->orders_crud_repository->get_company_orders($company_id,$filters);
    }

    public function GetOrder($order_id){
        return $this->orders_crud_repository->get_order_by_id($order_id);
    }

    public function ChangeOrderStatus($order_id,$data){
        $id = $this->orders_crud_repository->change_order_status($order_id,$data);
        if(isset($data['status_images'])){
            foreach ($data['status_images'] as $image) {
                $file = $this->FileUploadService->status($image,$data['company_id'],$id);
                $this->MediaService->save($file);
            }
        }
        return $id;
    }

}