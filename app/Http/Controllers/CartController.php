<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Cart\Interfaces\CartServiceInterface;

class CartController extends Controller
{
    
    public function __construct(
        protected readonly CartServiceInterface $CartService
    ) {}

    public function store(Request $request)
    {
        $data = $this->CartService->AddToCart($request->except('_token'));
        if($data){  
            return response()->json($data, 200);
        }
        return response()->json($data, 500);
    }

    public function update(Request $request)
    {
        $data = $this->CartService->UpdateCart($request->except('_token'));
        if($data){  
            return response()->json($data, 200);
        }
        return response()->json($data, 500);
    }

    public function destroy(string $variant_id)
    {
        $data = $this->CartService->DeleteFromCart($variant_id);
        if($data){  
            return response()->json($data, 200);
        }
        return response()->json($data, 500);
    }
}
