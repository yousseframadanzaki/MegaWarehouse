<?php

namespace App\Cart\Repositories;

use App\Cart\Interfaces\CartRepositoryInterface;
use Session;
class CartRepository implements CartRepositoryInterface{
    public function add_to_cart($item)
    {
        $cart = session('cart',array());
        $index = $this->exists($item['variant_id'],$cart);

        unset($item['variant_id']);

        if($index == -1){
            array_push($cart,$item);
        }else{
            $cart[$index]['quantity'] += $item['quantity'];
        }

        session(['cart' => $cart]);
        Session::save();
        return session('cart',array());
    }

    public function update_cart($item)
    {
        $cart = session('cart',array());
        $index = $this->exists($item['variant_id'],$cart);

        unset($item['variant_id']);

        if($index != -1){
            $cart[$index]['quantity'] = $item['quantity'];
            $cart[$index]['warehouse_id'] = $item['warehouse_id'];
        }

        session(['cart' => $cart]);
        Session::save();
        return true;
    }

    public function delete_from_cart($variant_id)
    {
        $cart = session('cart',array());
        $index = $this->exists($variant_id,$cart);

        if($index != -1){
            unset($cart[$index]);
        }

        session(['cart' => $cart]);
        Session::save();
        return true;
    }

    public function empty_cart()
    {
        session(['cart' => []]);
        Session::save();
        return true;
    }

    private function exists($id, $cart)
    {
        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]['variant']->id == $id) {
                return $i;
            }
        }
        return -1;
    }

}