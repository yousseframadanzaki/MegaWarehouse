<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Companies\Interfaces\CompanyCrudServiceInterface;
use App\Companies\Interfaces\CompanyActionsServiceInterface;
use App\Companies\Requests\CreateCompanyRequest;
use App\Companies\Requests\UpdateCompanyRequest;

class CompnayController extends Controller
{
    private CompanyCrudServiceInterface $CompanyCrudService;
    private CompanyActionsServiceInterface $CompanyActionsService;

    public function __construct(
        CompanyCrudServiceInterface $CompanyCrudService,
        CompanyActionsServiceInterface $CompanyActionsService
    ){
        $this->CompanyCrudService = $CompanyCrudService;
        $this->CompanyActionsService = $CompanyActionsService;
    }

    function all() {
        $companies = $this->CompanyCrudService->GetAllCompanies();
        return view('Companies.show_all')->with('companies',$companies);
    }

    function create() {
        return view('Companies.add');
    }

    function store(CreateCompanyRequest $request) {
        $company_id = $this->CompanyCrudService->CreateCompany($request->validated());
        if($company_id){
            return back()->with('success','company_created_success');
        }
        return back()->with('error','company_created_error');
    }

    function edit($company_id) {
        $company = $this->CompanyCrudService->GetCompany($company_id);
        if(!$company){
            return view('404');
        }
        return view('Companies.edit')->with('company',$company);
    }

    function update(UpdateCompanyRequest $request,$company_id) {
        $company = $this->CompanyCrudService->UpdateCompany($company_id,$request->validated());
        if(!$company){
            return back()->with('error','company_updated_error');
        }
        return back()->with('success','company_updated_success');
    }

    function activate($company_id) {
        if($this->CompanyActionsService->Activate($company_id)){
            return back()->with('success','company_activated_success');
        }
        return back()->with('error','company_activated_error');
    }

    function deactivate($company_id) {
        if($this->CompanyActionsService->Deactivate($company_id)){
            return back()->with('success','company_deactivated_success');
        }
        return back()->with('error','company_deactivated_error');
    }

}
