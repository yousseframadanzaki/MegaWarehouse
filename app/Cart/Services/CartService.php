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
        if ($item['is_bundle'] == 1) {
            $result = null;
            foreach ($item['variant_id'] as $id) {
                $variant = $this->CommonDataService->GetVariant($id);
                $bundle = $variant->bundles->find($item['product_id']);
                $variant['name'] = "( {$variant->product->name} ) - ( $variant->name )";
                $variant['price'] = $bundle->pivot->price;
                $variant['product']['name'] = $bundle->name;
                $variant['product']['marketer_commission'] = $bundle->marketer_commission;
                $item['variant'] = $variant;

                $result = $this->cart_repository->add_to_cart($item);
            }
            return $result;
        } else {
            $variant = $this->CommonDataService->GetVariant($item['variant_id']);
            $item['variant'] = $variant;
            return $this->cart_repository->add_to_cart($item);
        }
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

    public function EmptyCart()
    {
        return $this->cart_repository->empty_cart();
    }
}