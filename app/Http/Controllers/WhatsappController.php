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
    public function all_campaign(){
        $company_id = $this->company_id();
        $campaigns = $this->WhatsappService->GetCampaigns($company_id);
        return view('Dashboard.Whatsapp.show_all', compact('campaigns'));
    }
    public function edit_status($campaign_id,Request $request){
        $data = $request->except('_token');
        $status = $this->WhatsappService->ChangeCampaignStatus($campaign_id,$data['status']);
        return response()->json($status);
    }
    public function store_points(Request $request){
        $data = $request->all();
        unset($data['_token']);
        $user = auth()->user();
        $data['admin_id'] = "$user->id";
        $data['type'] = "add_ponits";
        $data['expire_date'] = Carbon::now()->addDays(30);

        if( $this->WhatsappService->AddPoints($data) ){
            $request->session()->flash('success', 'store_points_success');
            return redirect()->back();
        }
        return redirect()->back()->with(['error'=>'store_points_error','old_data'=>($request->except('token'))])->withInput();
    }
    public function show_campaign(Request $request) {
        $orders = $this->OrdersService->GetOrders($request->orders_ids);
        $user = auth()->user();
        $devices = $this->WhatsappService->GetDevices($user->id);
        foreach($devices as $device){
            $access_token = "6450f3b188e73";
            $headers = array(
                'Content-Type: application/json'
            );
            $url = 'https://whatsbotcloud.com/api/get_qrcode?instance_id=' . $device->instance_id . '&access_token=' . $access_token;
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
            curl_setopt($ch, CURLOPT_TIMEOUT, 60);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_REFERER, $url);
            curl_setopt($ch, CURLOPT_HTTPGET, 1);
            $result = curl_exec($ch);
            $decoded_result = json_decode($result, true);
            if (isset($decoded_result['status']) && $decoded_result['status'] == 'error' && isset($decoded_result['message']) && $decoded_result['message'] == 'instance id has been used') {
                $device['active'] = '1';
            }
            curl_close($ch);
        }
        $user_points = $this->WhatsappService->GetUserPoints($user->id);
        return view('Dashboard.Orders.campaign', compact('orders','user_points','devices'));
    }
    public function store_campaign(Request $request){
        $data = $request->except('_token');
        $user = auth()->user();
        $data['admin_number'] = $user->phone_1;
        $data['user_id'] = "$user->id";
        $random_delay = rand($data['min_time'], $data['max_time']);
        $data['delay'] = "$random_delay";
        $data['status'] = "pending";
        $phone_numbers_str = implode(',', $data['phone_numbers']);
        $order_ids_str = implode(',', $data['order_ids']);
        $messages = count($data['phone_numbers']);
        unset($data['phone_numbers']);
        $data['unsent_numbers'] = "$phone_numbers_str";
        $data['order_ids'] = "$order_ids_str";
        $schedule_date = Carbon::createFromFormat('m/d/Y h:i a', $data['schedule_date']);
        $formatted_schedule_date = $schedule_date->format('Y-m-d H:i:s');
        $data['schedule_date'] = $formatted_schedule_date;

        $details['messages'] = $messages;
        $campaign_id = $this->WhatsappService->StoreCampagin($data);
        $details['campaign_id'] = $campaign_id;
        $details['user_id'] = "$user->id";
        $details['type'] = "send_message";
        $whatsapp_messages = $this->WhatsappService->AddPoints($details);
        if($campaign_id && $whatsapp_messages){
            return redirect()->route('whatsapp_campaigns')
            ->with('success', 'create_campaign_success');
        }
    }
    public function add_device(Request $request) {
        $data = $request->except('_token');
        $user = auth()->user();
        $data['user_id'] = $user->id;

        $access_token = "6450f3b188e73";
        $url = "https://whatsbotcloud.com/api/create_instance?access_token=" . $access_token;
        $headers = array(
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        $result = curl_exec($ch);
        $result =  explode(',', $result);
        $array = explode(':', $result[2]);
        $array[1] = preg_replace('/[^A-Za-z0-9\-]/', '', $array[1]);
        $instance_id = $array[1];
        $data['instance_id'] = $instance_id;

        if( $this->WhatsappService->AddDevice($data)){
            $request->session()->flash('success', 'add_device_success');
            return redirect()->back();
        }
        return redirect()->back()->with(['error'=>'add_device_error','old_data'=>($request->except('token'))])->withInput();
    }
    function delete_device($device_id) {
        $device = $this->WhatsappService->DeleteDevice($device_id);
        return response()->json($device);
    }
    public function get_qr_code($instance_id){
        $access_token = "6450f3b188e73";
        $headers = array(
            'Content-Type: application/json'
        );
        $url = 'https://whatsbotcloud.com/api/get_qrcode?instance_id=' . $instance_id . '&access_token=' . $access_token;
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_REFERER, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, 1);
        $result = curl_exec($ch);
        echo json_encode($result);
        exit();
    }
}
