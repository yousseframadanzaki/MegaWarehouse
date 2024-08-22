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

    public function update(Request $request) {
        $result = $this->ShippingAreaService->UpdateShippingAreaActive2($request->except('_token'));
        if ($result) {
            return redirect()->back()->with('success', 'تمت العملية بنجاح');
        }

        return redirect()->back()->with('error', 'فشل تنفيذ العملية');
    }
}
