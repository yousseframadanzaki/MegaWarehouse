<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Suppliers\Interfaces\SupplierCrudServiceInterface;
use App\Suppliers\Requests\CreateSupplierRequest;
use App\Suppliers\Requests\UpdateSupplierRequest;

class SupplierController extends Controller
{
    private SupplierCrudServiceInterface $SupplierCrudService;

    public function __construct(SupplierCrudServiceInterface $SupplierCrudService){
        $this->SupplierCrudService = $SupplierCrudService;
    }

    public function all() {
        $company_id = auth()->user()->company_id;
        $suppliers = $this->SupplierCrudService->GetCompanySuppliers($company_id);
        return view('Dashboard.Suppliers.show_all')->with('suppliers',$suppliers);
    }

    public function create() {
        return view('Dashboard.Suppliers.add');
    }

    public function store(CreateSupplierRequest $request) {
        $company_id = auth()->user()->company_id;
        $supplier = $this->SupplierCrudService->CreateSupplier($company_id,$request->validated());
        if(!$supplier){
            return back()->with('error','supplier_created_error');
        }
        return back()->with('success','supplier_created_success');
    }

    public function edit($supplier_id) {
        $supplier = $this->SupplierCrudService->GetSupplier($supplier_id);
        return view('Dashboard.Suppliers.edit')->with('supplier',$supplier);
    }

    public function update(UpdateSupplierRequest $request,$supplier_id) {
        $supplier = $this->SupplierCrudService->UpdateSupplier($supplier_id,$request->validated());
        if(!$supplier){
            return back()->with('error','supplier_updated_error');
        }
        return back()->with('success','supplier_updated_success');
    }

    public function show($supplier_id) {
        $data = $this->SupplierCrudService->GetSupplierWithProducts($supplier_id);
        // dd($data);
        return view("Dashboard.Suppliers.show_one")->with('data',$data);
    }

}
