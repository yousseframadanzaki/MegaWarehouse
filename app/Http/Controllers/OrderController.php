<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Orders\Requests\CreateOrderRequest;

class OrderController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    public function __construct(
        CommonDataServiceInterface $CommonDataService,
    )
    {
        $this->CommonDataService = $CommonDataService;
    }

    public function create() {
        $company_id = $this->company_id();
        $clients = $this->CommonDataService->GetCompanyClients($company_id);
        $countries = $this->CommonDataService->GetCountries();
        $products = $this->CommonDataService->GetCompanyProducts($company_id);
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        return view('Dashboard.Orders.add')->with(compact('clients','countries','products','warehouses'));
    }

    public function store(CreateOrderRequest $request){
        dd($request->all());
    }

}
