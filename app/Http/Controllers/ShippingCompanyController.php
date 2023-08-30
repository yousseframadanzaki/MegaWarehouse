<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ShippingCompanies\Interfaces\ShippingCompanyServiceInterface;
use App\ShippingStatus\Interfaces\ShippingStatusServiceInterface;
use App\ShippingAreas\Interfaces\ShippingAreaServiceInterface;

use App\ShippingCompanies\Requests\CreateShippingCompanyRequest;
use App\ShippingCompanies\Requests\UpdateShippingCompanyRequest;
use App\CommonData\Interfaces\CommonDataServiceInterface;
class ShippingCompanyController extends Controller
{
    public function __construct(
       protected readonly ShippingCompanyServiceInterface $ShippingCompanyService,
       protected readonly ShippingStatusServiceInterface $ShippingStatusService,
       protected readonly ShippingAreaServiceInterface $ShippingAreaService,
       protected readonly CommonDataServiceInterface $CommonDataService,
    ) {}

    public function all()
    {
        $shipping_companies = $this->ShippingCompanyService->GetCompanyShippingCompanies($this->company_id());
        return view('Dashboard.ShippingCompanies.show_all')->with(compact('shipping_companies'));
    }

    public function show($shipping_company_id) {
        $shipping_company = $this->ShippingCompanyService->GetShippingCompany($shipping_company_id);
        $shipping_company_statuses = $this->ShippingStatusService->GetShippingCompanyStatuses($shipping_company);
        $statuses = $this->CommonDataService->GetCompanyStatuses();
        return view('Dashboard.ShippingCompanies.show_one')->with(compact('statuses','shipping_company','shipping_company_statuses'));
    }

    public function show_sectors($shipping_company_id) {
        $shipping_company = $this->ShippingCompanyService->GetShippingCompany($shipping_company_id);
        $shipping_company_areas = $this->ShippingAreaService->GetShippingCompanyAreas($shipping_company);
        $areas = $this->CommonDataService->GetAreas();
        return view('Dashboard.ShippingCompanies.show_one')->with(compact('areas','shipping_company','shipping_company_areas'));
    }

    public function create()
    {
        $company_id = $this->company_id();
        $roles = $this->CommonDataService->GetRolesByType($company_id,'shipping_company');
        return view('Dashboard.ShippingCompanies.add')->with('roles',$roles);
    }
    
    public function store(CreateShippingCompanyRequest $request)
    {
        if(!$this->ShippingCompanyService->AddShippingCompany($this->company_id(),$request->except('_token'))){
            return redirect()->back()->with('error','create_shipping_company_error');
        }
        return redirect()->back()->with('success','create_shipping_company_success');
    }

    public function edit($shipping_company_id)
    {
        $shipping_company = $this->ShippingCompanyService->GetShippingCompany($shipping_company_id);
        return view('Dashboard.ShippingCompanies.edit')->with(compact('shipping_company'));
    }

    public function update(UpdateShippingCompanyRequest $request,$shipping_company_id)
    {
        if(!$this->ShippingCompanyService->UpdateShippingCompany($shipping_company_id,$request->except('_token'))){
            return redirect()->back()->with('error','update_shipping_company_error');
        }
        return redirect()->back()->with('success','update_shipping_company_success');
    }

    public function activate($shipping_company_id){
        if($this->ShippingCompanyService->Activate($shipping_company_id)){
            return redirect()->back()->with('success','activate_shipping_company_success');
        }
        return redirect()->back()->with('error','activate_shipping_company_error');
    }

    public function deactivate($shipping_company_id){
        if($this->ShippingCompanyService->Deactivate($shipping_company_id)){
            return redirect()->back()->with('success','deactivate_shipping_company_success');
        }
        return redirect()->back()->with('error','deactivate_shipping_company_error');
    }


}
