<?php

namespace App\Whatsapp\Interfaces;

interface WhatsappServiceInterface
{
    public function AddPoints($data);
    public function GetUserPoints($user_id);
    public function GetDevices($user_id);
    public function AddDevice($data);
    public function DeleteDevice($device_id);
    public function StoreCampagin($data);
}
