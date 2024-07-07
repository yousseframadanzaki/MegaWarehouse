<?php

namespace App\Whatsapp\Repositories;

use App\Whatsapp\Interfaces\WhatsappRepositoryInterface;
use App\Models\WhatsappUserPoint;
use App\Models\WhatsappDevice;
use App\Models\WhatsappCampaign;
use Illuminate\Support\Facades\DB;


class WhatsappRepository implements WhatsappRepositoryInterface
{
    public function add_points($data){
        return WhatsappUserPoint::create($data);
    }
    public function get_campaigns($company_id){
        return DB::table('whatsapp_campaigns')
            ->leftJoin('users', 'whatsapp_campaigns.user_id', '=', 'users.id')
            ->leftJoin('orders', function($join) {
                $join->on(DB::raw('FIND_IN_SET(orders.id, whatsapp_campaigns.order_ids)'), '>', DB::raw('0'));
            })
            ->select(
                'whatsapp_campaigns.id',
                'whatsapp_campaigns.name',
                'whatsapp_campaigns.schedule_date',
                'whatsapp_campaigns.status',
                'users.name as user_name',
                DB::raw('GROUP_CONCAT(orders.id SEPARATOR ",") as order_ids'),
                DB::raw('GROUP_CONCAT(orders.order_code SEPARATOR ",") as order_codes')
            )
            ->where('users.company_id', $company_id)
            ->groupBy(
                'whatsapp_campaigns.id',
                'whatsapp_campaigns.name',
                'whatsapp_campaigns.schedule_date',
                'whatsapp_campaigns.status',
                'users.name'
            )
            ->get();
    }
    public function change_campaign_status($campaign_id,$status){
        $campaign = WhatsappCampaign::find($campaign_id);
        $campaign->status = $status;
        $campaign->save();
        return true;
    }
    public function get_user_points($user_id) {
        return DB::table('whatsapp_user_points')
            ->selectRaw(
                '(COALESCE((SELECT points FROM whatsapp_user_points WHERE user_id = ? AND type = ?), 0) -
                  COALESCE((SELECT SUM(messages) FROM whatsapp_user_points WHERE user_id = ? AND type = ?), 0)) AS points,
                 (SELECT expire_date FROM whatsapp_user_points WHERE user_id = ? AND type = ?) AS expire_date',
                [$user_id, 'add_ponits', $user_id, 'send_message', $user_id, 'add_ponits']
            )
            ->first();
    }
    public function get_devices($user_id){
        return WhatsappDevice::where('user_id',$user_id)->get();
    }
    public function add_device($data){
        return WhatsappDevice::create($data);
    }
    public function delete_device($device_id){
        return WhatsappDevice::where('id',$device_id)->delete();
    }
    public function store_campagin($data){
        $campaign = WhatsappCampaign::create($data);
        return $campaign->id;
    }
}
