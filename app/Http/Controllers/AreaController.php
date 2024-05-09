<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Area\Interfaces\AreaServiceInterface;
use function Ramsey\Uuid\v1;

class AreaController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private AreaServiceInterface $AreaService;
    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        AreaServiceInterface $AreaService,
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->AreaService = $AreaService;
    }
    public function all_sectors(){
        $sectors = $this->AreaService->GetAllSectors();
        return view('Dashboard.Area.show_all',compact('sectors'));
    }
    public function edit_area($area_id ,Request $request){
        $data = $request->all();
        $price = $data['price'];

        $sector = $this->AreaService->EditArea($area_id, $price);
        //return response()->json($sector, 200);
        return response()->json($sector);
        // if($sector){
        //     return redirect()->back()->with('success','order_status_change_success');
        // }
    }
}
