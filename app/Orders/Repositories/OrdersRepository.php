<?php

namespace App\Orders\Repositories;

use App\Orders\Interfaces\OrdersRepositoryInterface;
use App\Models\Order;

class OrdersRepository implements OrdersRepositoryInterface{
    public function create_order(array $data){
        return  Order::create($data);
    }
}