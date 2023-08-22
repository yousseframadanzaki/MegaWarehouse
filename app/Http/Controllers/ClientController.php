<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Clients\Interfaces\ClientCrudServiceInterface;
use App\Clients\Requests\CreateClientRequest;
use App\Clients\Requests\UpdateClientRequest;

class ClientController extends Controller
{
    private ClientCrudServiceInterface $ClientCrudService;
    private CommonDataServiceInterface $CommonDataService;

    public function __construct(ClientCrudServiceInterface $ClientCrudService, CommonDataServiceInterface $CommonDataService)
    {
        $this->CommonDataService = $CommonDataService;
        $this->ClientCrudService = $ClientCrudService;
    }

    public function all()
    {
        $company_id = $this->company_id();
        $clients = $this->ClientCrudService->GetCompanyClients($company_id);
        return view('Dashboard.Clients.show_all')->with('clients',$clients);
    }

    public function create()
    {
        $company_id = $this->company_id();
        $client_groups = $this->CommonDataService->GetCompanyClientGroups($company_id);
        $countries = $this->CommonDataService->GetCountries();
        return view('Dashboard.Clients.add')->with(['client_groups' => $client_groups, 'countries' => $countries]);
    }

    public function store(CreateClientRequest $request)
    {
        $company_id = $this->company_id();
        $client = $this->ClientCrudService->CreateClient($company_id,$request->validated());
        if($client){
            return back()->with('success','client_created_success');
        }
        return back()->with('error','client_created_error');
    }

    public function edit($client_id)
    {
        $company_id = $this->company_id();
        $client = $this->ClientCrudService->GetClient($client_id);
        $client_groups = $this->CommonDataService->GetCompanyClientGroups($company_id);

        $countries = $this->CommonDataService->GetCountries();
        $cities = $this->CommonDataService->GetCities($client->country_id);
        $areas = $this->CommonDataService->GetAreas($client->city_id);

        return view('Dashboard.Clients.edit')->with(
            ['client'=>$client,
            'countries'=>$countries,
            'cities'=>$cities,
            'areas'=>$areas,
            'client_groups'=>$client_groups]);
    }

    public function update(UpdateClientRequest $request, $client_id)
    {
        if(!$this->ClientCrudService->UpdateClient($client_id,$request->validated())){
            return back()->with('error','client_updated_error');
        }
        return back()->with('success','client_updated_success');
    }

    public function get_client_by_phone($phone) {
        $client = $this->ClientCrudService->GetClientByPhone($phone);
        if(!$client){
            return response([],404);
        }
        $citites = $this->CommonDataService->GetCities($client->country_id);
        $areas = $this->CommonDataService->GetAreas($client->city_id);
        return response()->json(array('client'=>$client,'areas'=>$areas,'citites'=>$citites));
    }

}
