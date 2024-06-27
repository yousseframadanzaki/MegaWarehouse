<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Marketers\Interfaces\MarketerCrudServiceInterface;
use App\Marketers\Requests\CreateMarketerRequest;
use App\Marketers\Requests\UpdateMarketerRequest;

class MarketerController extends Controller
{

    public function __construct(
        protected readonly MarketerCrudServiceInterface $MarketerCrudService,
        protected readonly CommonDataServiceInterface $CommonDataService,
    ){}

    public function all()
    {
        $company_id = $this->company_id();
        $marketers = $this->MarketerCrudService->GetCompanyMarketers($company_id);
        return view('Dashboard.Marketers.show_all')->with('marketers',$marketers);
    }

    public function create()
    {
        $company_id = $this->company_id();
        $user_type_id = 3;
        $roles = $this->CommonDataService->GetRolesByType($company_id,$user_type_id);
        return view('Dashboard.Marketers.add')->with('roles',$roles);
    }

    public function store(CreateMarketerRequest $request)
    {
        $company_id = $this->company_id();
        // dd($request->all());
        $marketer = $this->MarketerCrudService->CreateMarketer($company_id,$request->except('token'));
        if($marketer){
            return back()->with('success','marketer_created_success');
        }
        return back()->with('error','marketer_created_error');
    }

    public function edit($marketer_id)
    {
        $marketer = $this->MarketerCrudService->GetMarketer($marketer_id);
        return view('Dashboard.Marketers.edit')->with(['marketer'=>$marketer]);
    }

    public function update(UpdateMarketerRequest $request, $marketer_id)
    {
        if(!$this->MarketerCrudService->UpdateMarketer($marketer_id,$request->except('token'))){
            return back()->with('error','marketer_updated_error');
        }
        return back()->with('success','marketer_updated_success');
    }

    public function show($marketer_id) {
        $marketer = $this->MarketerCrudService->GetMarketer($marketer_id);
        return view("Dashboard.Marketers.show_one", compact('marketer'));
    }
}
