<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\CommonData\Interfaces\CommonDataServiceInterface;
use App\Whatsapp\Interfaces\WhatsappServiceInterface;
use App\Orders\Interfaces\OrdersServiceInterface;
use Carbon\Carbon;
use function Ramsey\Uuid\v1;

class WhatsappController extends Controller
{
    private CommonDataServiceInterface $CommonDataService;
    private WhatsappServiceInterface $WhatsappService;
    private OrdersServiceInterface $OrdersService;
    public function __construct(
        CommonDataServiceInterface $CommonDataService,
        WhatsappServiceInterface $WhatsappService,
        OrdersServiceInterface $OrdersService,
    )
    {
        $this->CommonDataService = $CommonDataService;
        $this->WhatsappService = $WhatsappService;
        $this->OrdersService = $OrdersService;
    }
    public function add_points(){
        $company_id = $this->company_id();
        $users = $this->CommonDataService->GetCompanyUsers($company_id);
        return view('Dashboard.Whatsapp.add_points', compact('users'));
    }
    public function store_points(Request $request){
        $data = $request->all();
        unset($data['_token']);
        $user = auth()->user();
        $data['admin_id'] = "$user->id";
        $data['type'] = "add_ponits";
        $data['expire_date'] = Carbon::now()->addDay();
        // dd($data);
        if( $this->WhatsappService->AddPoints($data) ){
            $request->session()->flash('success', 'store_points_success');
            return redirect()->back();
        }
        return redirect()->back()->with(['error'=>'store_points_error','old_data'=>($request->except('token'))])->withInput();
    }
    public function show_campaign(Request $request) {
        $orders = $this->OrdersService->GetOrders($request->orders_ids);
        return view('Dashboard.Orders.campaign', compact('orders'));
    }
}
