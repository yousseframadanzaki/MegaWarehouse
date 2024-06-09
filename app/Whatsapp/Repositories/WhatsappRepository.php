<?php

namespace App\Whatsapp\Repositories;

use App\Whatsapp\Interfaces\WhatsappRepositoryInterface;
use App\Models\WhatsappUserPoint;
use App\Models\WhatsappDevice;


class WhatsappRepository implements WhatsappRepositoryInterface
{
    public function add_points($data){
        return WhatsappUserPoint::create($data);
    }
    public function get_user_points($user_id){
        return WhatsappUserPoint::where('user_id',$user_id)->firstOrfail();
    }
    public function get_devices($user_id){
        return WhatsappDevice::where('user_id',$user_id)->get();
    }
    public function add_device($data){
        return WhatsappDevice::create($data);
    }
}
