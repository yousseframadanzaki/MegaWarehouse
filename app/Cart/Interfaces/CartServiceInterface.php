<?php

namespace App\Cart\Interfaces;

interface CartServiceInterface{
    public function AddToCart($item);

    public function UpdateCart($item);

    public function DeleteFromCart($item);
}