<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
class StockController extends Controller
{
    public function __construct(
       private readonly CommonDataServiceInterface $CommonDataService
    ){}

    public function create() {
        $company_id = auth()->user()->company_id;
        $warehouses = $this->CommonDataService->GetCompanyWarehouses($company_id);
        $products   = $this->CommonDataService->GetCompanyProducts($company_id);
        return view('Dashboard.Stock.add')->with(compact('warehouses','products'));
    }
}
