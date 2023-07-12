<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Companies\Interfaces\CompanyCrudServiceInterface;
use App\Companies\Requests\CreateCompanyRequest;

class CompnayController extends Controller
{
    private CompanyCrudServiceInterface $CompanyCrudService;

    public function __construct(CompanyCrudServiceInterface $CompanyCrudService){
        $this->CompanyCrudService = $CompanyCrudService;
    }

    function create() {
        return view('Companies.add');
    }
    function store(CreateCompanyRequest $request) {
        $company_id = $this->CompanyCrudService->CreateCompany($request->all());
        if($company_id){
            return back()->with('success','Company created successfully!');
        }
        return back()->with('error','You have no permission for this page!');
    }

}
