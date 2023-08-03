<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Stock\Interfaces\StockOperationServiceInterface;
use App\Stock\Filters\StockFilters;

use App\Stock\Requests\CreateStockRequest;

class StockController extends Controller
{
    public function __construct(
       private readonly CommonDataServiceInterface $CommonDataService,
       private readonly StockOperationServiceInterface $StockOperationService,
    ){}

    public function all(StockFilters $filters) {
        $company_id = auth()->user()->company_id;
        $stock = $this->StockOperationService->GetCompanyStock($company_id,$filters);

        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $products   = $this->CommonDataService->GetCompanyProducts($company_id);
        $users   = $this->CommonDataService->GetCompanyUsers($company_id);

        $data = array(
            "warehouses"=>$warehouses,
            "products"=>$products,
            "users"=>$users,
        );

        return view('Dashboard.Stock.show_all')->with(['stock'=>$stock,'data'=>$data]);
    }

    public function create() {
        $company_id = auth()->user()->company_id;
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $products   = $this->CommonDataService->GetCompanyProducts($company_id);
        return view('Dashboard.Stock.add')->with(compact('warehouses','products'));
    }

    public function store(CreateStockRequest $request) {
        $user = auth()->user();
        $ids = $this->StockOperationService->CreateOperation($user,$request->all());
        if($ids){
            return redirect()->back()->with('success','stock_add_success');
        }
        return redirect()->back()->with('error','stock_add_error');
    }

}
