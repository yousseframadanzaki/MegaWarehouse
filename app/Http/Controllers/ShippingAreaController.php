<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingAreas\Interfaces\ShippingAreaServiceInterface;

class ShippingAreaController extends Controller
{
    public function __construct(
        protected readonly ShippingAreaServiceInterface $ShippingAreaService,
    ) {}

    public function map(Request $request)
    {
        $data = $this->ShippingAreaService->UpsertMapping($request->all());
        return response()->json($data);
    }
}
