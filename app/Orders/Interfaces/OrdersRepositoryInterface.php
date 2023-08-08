<?php

namespace App\Orders\Interfaces;

interface OrdersRepositoryInterface{
    public function create_order(array $data);
}