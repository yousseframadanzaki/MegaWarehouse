<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Area\Interfaces\AreaServiceInterface;
use App\Area\Requests\CreateAreaRequest;
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
        $cities = $this->CommonDataService->GetCities();
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        return view('Dashboard.Area.show_all',compact('sectors','cities','shipping_companies'));
    }
    public function edit_area($area_id ,Request $request){
        $data = $request->all();
        $price = $data['price'];
        $sector = $this->AreaService->EditArea($area_id, $price);
        if ($sector) {
            return response()->json($sector);
        }
    }
    public function edit_city($area_id ,Request $request){
        $data = $request->all();
        $city_id = $data['city_id'];
        $city = $this->AreaService->EditCity($area_id, $city_id);
        if ($city) {
            return response()->json($city);
        }
    }
    public function edit_shipping_company($area_id ,Request $request){
        $data = $request->all();
        $shipping_company_id = $data['shipping_company_id'];
        $shipping_company = $this->AreaService->EditShippingCompany($area_id, $shipping_company_id);
        if ($shipping_company) {
            return response()->json($shipping_company);
        }
    }
    public function add_sector(){
        $cities = $this->CommonDataService->GetCities();
        $shipping_companies = $this->CommonDataService->GetCompanyShippingCompanies($this->company_id());
        return view('Dashboard.Area.add',compact('cities','shipping_companies'));
    }
    public function store_sector(CreateAreaRequest $request){
        $data = $request->all();
        unset($data['_token']);
        if($this->AreaService->CreateSector($data)){
            return redirect()->route('all_sectors')->with('success','create_area_success');
        }
    }
}
