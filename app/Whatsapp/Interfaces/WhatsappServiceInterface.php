<?php

namespace App\Whatsapp\Interfaces;

interface WhatsappServiceInterface
{
    public function AddPoints($data);
    public function GetUserPoints($user_id);
    public function GetDevices();
    public function AddDevice($data);
}
