<?php

namespace App\Cart\Interfaces;

interface CartRepositoryInterface{

    public function add_to_cart($item);
    public function update_cart($item);
    public function delete_from_cart($item);
    
}