<?php

namespace App\Orders\Services;

use App\Orders\Interfaces\OrdersRepsoitoryInterface;
use App\Orders\Interfaces\OrdersServiceInterface;

class OrdersService implements OrdersServiceInterface{


    public function __construct(
        protected readonly  ClientCrudServiceInterface $ClientCrudService,
        protected readonly  StockServiceInterface $StockService,
        protected readonly  OrdersRepsoitoryInterface $orders_crud_repository,
    ) {}

    public function AddOrder($company_id,array $data){

        $items = $data['items'];
        unset($data['items']);

        if(!$this->StockService->CheckAvailableItems($items)){
            return false;
        }
        $data['company_id'] = $company_id;
        if(!isset($data['client_id'])){
            $saved_client = $this->ClientCrudService->CreateClient($company_id,$data['client']);
            $data['client_id'] = $saved_client->id;
        }
        $order =  $this->orders_crud_repository($data);
        $prepared_items = [];
        foreach ($items as $item) {
            $prepared_items[$item['id']] = ['value' => $item];
        }
        $items['order_id'] = $order->id;
        $this->StockService->buy($items);
        return;
    }
}