<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Status\Interfaces\StatusServiceInterface;
use App\Models\Status;
use function Ramsey\Uuid\v1;

class StatusController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private StatusServiceInterface $StatusService;
    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        StatusServiceInterface $StatusService,
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->StatusService = $StatusService;
    }
    public function statuses_settings(){
        $statuses = $this->CommonDataService->GetCompanyStatuses($this->company_id());
        $statuses = $statuses->map(function ($status) {
            $status->related_statuses = $status->getRelatedStatuses();
            return $status;
        });
        return view('Dashboard.Status.statuses_settings',compact('statuses'));
    }
    public function update_status($status_id, Request $request){
        $data = $request->all();
        $edit_order = $data['edit_order'];
        $status = $this->StatusService->UpdateStatus($status_id,$edit_order);
        return response()->json($status);
    }
    public function update_related_shipping(Request $request){
        $status = $this->StatusService->UpdateRelatedShipping($request->except("_token"));
        return response()->json($status);
    }
    public function update_show_all_orders(Request $request) {
        $status = $this->StatusService->UpdateShowAllOrders($request->except("_token"));
        return response()->json($status);
    }
    public function update_status_color(Request $request) {
        $status = $this->StatusService->UpdateStatusColor($request->except("_token"));
        return response()->json($status);
    }
    public function add_related_status($status_id, Request $request){
        $data = $request->all();
        $related_status = $data['related_status'];
        $status = $this->StatusService->AddRelatedStatus($status_id,$related_status);
        return response()->json($status);
    }
    public function remove_related_status($related_status, Request $request){
        $data = $request->all();
        $status_id = $data['status_id'];
        $status = $this->StatusService->RemoveRelatedStatus($related_status, $status_id);
        return response()->json($status);
    }
}
