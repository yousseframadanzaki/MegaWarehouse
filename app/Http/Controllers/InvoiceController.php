<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;

use App\Invoices\Interfaces\InvoiceServiceInterface;
use App\Invoices\Filters\InvoiceFilters;
use App\Invoices\Requests\PayInvoiceRequest;

class InvoiceController extends Controller
{
    public function __construct(
        protected readonly CommonDataServiceInterface $CommonDataService,
        protected readonly InvoiceServiceInterface $InvoiceService
    ) {}

    public function all(InvoiceFilters $filters)
    {
        $company_id = $this->company_id();
        $invoices = $this->InvoiceService->GetCompanyInvoices($company_id,$filters);

        // dd($invoices);

        $suppliers   = $this->CommonDataService->GetCompanySuppliers($company_id);
        $filters = $filters->get_values();

        $data = array(
            "suppliers"=>$suppliers,
            "filters"=>$filters,
        );

        return view('Dashboard.Invoices.show_all')->with(['invoices'=>$invoices,'data'=>$data]);
    }

    public function show($invoice_id)
    {
        $invoice = $this->InvoiceService->GetInvoice($invoice_id);
        
        $users = $this->CommonDataService->GetUsersByRoleType($this->company_id(),'manager');
        return view('Dashboard.Invoices.show_one')->with(['invoice'=>$invoice,'users'=>$users]);
    }

    public function pay(PayInvoiceRequest $request,$invoice_id)
    {
       if($this->InvoiceService->PayInvoice($invoice_id,$request->validated())){
            return redirect()->back()->with('success','pay_invoice_success');
       } 
       return redirect()->back()->with('error','pay_invoice_error');
    }

}
