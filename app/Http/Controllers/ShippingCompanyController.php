<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\ShippingCompanies\Requests\CreateShippingCompanyRequest;

class ShippingCompanyController extends Controller
{
    public function __construct(
       protected readonly ShippingCompanyServiceInterface $ShippingCompanyService
    ) {}

    public function create()
    {
        return view('Dashboard.ShippingCompanies.add');
    }
    
    public function store(CreateShippingCompanyRequest $request)
    {
        if(!$this->ShippingCompanyService->AddShippingCompany($this->company_id(),$request->except('_token'))){
            return redirect()->back()->with('error','create_shipping_company_error');
        }
        return redirect()->back()->with('success','create_shipping_company_success');
    }

}
