<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingStatus\Interfaces\ShippingStatusServiceInterface;



class ShippingStatusController extends Controller
{


    public function __construct(
        protected readonly ShippingStatusServiceInterface $ShippingStatusService,
    ) {}

    public function map(Request $request)
    {
        if(!$this->ShippingStatusService->UpsertMapping($request->all())){
            return response()->json('',404);
        }
        return response()->json($request->all());
    }
}
