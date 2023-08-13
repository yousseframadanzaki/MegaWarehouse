<?php

namespace App\Cart\Services;
use App\Cart\Interfaces\CartRepositoryInterface;
use App\Cart\Interfaces\CartServiceInterface;
use App\CommonData\Interfaces\CommonDataServiceInterface;
class CartService implements CartServiceInterface{
    
    public function __construct(
        protected readonly CartRepositoryInterface $cart_repository,
        protected readonly CommonDataServiceInterface $CommonDataService
    ) {}

    public function AddToCart($item)
    {
        $variant = $this->CommonDataService->GetVariant($item['variant_id']);
        $item['variant'] = $variant;
        return $this->cart_repository->add_to_cart($item);
    }

    public function UpdateCart($item)
    {
        $variant = $this->CommonDataService->GetVariant($item['variant_id']);
        $item['variant'] = $variant;
        return $this->cart_repository->update_cart($item);
    }

    public function DeleteFromCart($variant_id)
    {
        return $this->cart_repository->delete_from_cart($variant_id);
    }
}