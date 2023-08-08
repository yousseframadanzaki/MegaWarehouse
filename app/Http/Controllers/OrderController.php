<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use App\Orders\Requests\CreateOrderRequest;

class OrderController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private OrdersServiceInterface $OrdersService;
    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        OrdersServiceInterface $OrdersService
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->OrdersService = $OrdersService;
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
        if( $this->OrdersService->AddOrder(auth()->user(),$request->all()) ){
            return redirect()->back()->with('success','order_created_success');
        }
        return redirect()->back()->with('error','order_created_error');
    }

}
