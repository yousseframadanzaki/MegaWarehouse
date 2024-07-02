<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Warehouses\Interfaces\WarehouseCrudServiceInterface;
use App\Warehouses\Requests\CreateWarehouseRequest;
use App\Warehouses\Requests\UpdateWarehouseRequest;

class WarehouseController extends Controller
{

    private WarehouseCrudServiceInterface $WarehouseCrudService;

    public function __construct(WarehouseCrudServiceInterface $WarehouseCrudService){
        $this->WarehouseCrudService = $WarehouseCrudService;
    }

    public function all()
    {
        $company_id = $this->company_id();
        $warehouses = $this->WarehouseCrudService->GetCompanyWarehouses($company_id);
        return view('Dashboard.Warehouses.show_all')->with('warehouses',$warehouses);
    }

    public function create()
    {
        return view('Dashboard.Warehouses.add');
    }

    public function store(CreateWarehouseRequest $request)
    {
        $company_id = $this->company_id();
        $warehouse = $this->WarehouseCrudService->CreateWarehouse($company_id,$request->validated());
        if(!$warehouse){
            return back()->with('error','created_error');
        }
        return back()->with('success','created_success');
    }

    public function edit($warehouse_id)
    {
        $warehouse = $this->WarehouseCrudService->GetWarehouse($warehouse_id);
        return view('Dashboard.Warehouses.edit')->with('warehouse',$warehouse);
    }

    public function update(UpdateWarehouseRequest $request,$warehouse_id)
    {
        $warehouse = $this->WarehouseCrudService->UpdateWarehouse($warehouse_id,$request->validated());
        if(!$warehouse){
            return back()->with('error','updated_error');
        }
        return back()->with('success','updated_success');
    }

}
