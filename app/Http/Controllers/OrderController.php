<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;

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
        return view('Dashboard.Orders.add')->with(compact('clients','countries'));
    }
}
