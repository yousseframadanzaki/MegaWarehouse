<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use App\Orders\Requests\CreateOrderRequest;
use App\Orders\Filters\OrdersFilters;

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

    public function all(OrdersFilters $filters) {
        $clients = $this->CommonDataService->GetCompanyClients($this->company_id());
        $cities = $this->CommonDataService->GetCities();
        $statuses = $this->CommonDataService->GetCompanyStatuses($this->company_id());

        $orders = $this->OrdersService->GetCompanyOrders($this->company_id(),$filters);
        return view('Dashboard.Orders.show_all')->with(
            compact(
                'orders',
                'clients',
                'cities',
                'statuses'
            ));
    }

    public function show_one($order_id) {
        $order = $this->OrdersService->GetOrder($order_id);
        $statuses = $this->CommonDataService->GetCompanyStatuses($this->company_id());
        // dd($statuses);   
        return view('Dashboard.Orders.show_one',compact('order','statuses'));
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
        return redirect()->back()->with(['error'=>'order_created_error','old_data'=>$request->except('token')])->withInput();
    }

    public function change_status(Request $request,$order_id) {

        $data = $request->all();
        $data['admin_id'] = auth()->user()->id;

        if($this->OrdersService->ChangeOrderStatus($order_id,$data)){
            return redirect()->back()->with('succes','order_status_change_success');
        }
        return redirect()->back()->with('succes','order_status_change_error');
    }

}
