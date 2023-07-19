<?php

namespace App\Http\Controllers;

use App\Models\ClientGroup;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Clients\Interfaces\ClientGroupCrudServiceInterface;
use App\Clients\Requests\CreateClientGroupRequest;
use App\Clients\Requests\UpdateClientGroupRequest;

class ClientGroupController extends Controller
{


    private ClientGroupCrudServiceInterface $ClientGroupCrudService;

    public function __construct(ClientGroupCrudServiceInterface $ClientGroupCrudService)
    {
        $this->ClientGroupCrudService = $ClientGroupCrudService;
    }

    public function all()
    {
        $company_id = auth()->user()->company_id;
        $client_groups = $this->ClientGroupCrudService->GetCompanyClientGroups($company_id);
        return view('Dashboard.ClientGroups.show_all')->with('client_groups',$client_groups);
    }

    public function create()
    {
        return view('Dashboard.ClientGroups.add');
    }

    
    public function store(CreateClientGroupRequest $request)
    {
        $company_id = auth()->user()->company_id;
        $client_group = $this->ClientGroupCrudService->CreateClientGroup($company_id,$request->validated());
        if($client_group){
            return back()->with('success','client_group_created_success');
        }
        return back()->with('error','client_group_created_error');
    }

    
    public function edit($client_group_id)
    {
        $client_group = $this->ClientGroupCrudService->GetClientGroup($client_group_id);
        return view('Dashboard.ClientGroups.edit')->with('client_group',$client_group);
    }

    
    public function update(UpdateClientGroupRequest $request,$client_group_id)
    {
        if(!$this->ClientGroupCrudService->UpdateClientGroup($client_group_id,$request->validated())){
            return back()->with('error','client_group_updated_error');
        }
        return back()->with('success','client_group_updated_success');
    }
}
