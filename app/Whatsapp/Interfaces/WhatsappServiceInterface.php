<?php

namespace App\Whatsapp\Interfaces;

interface WhatsappServiceInterface
{
    public function AddPoints($data);
    public function GetUserPoints($user_id);
}
