<?php

namespace App\Whatsapp\Interfaces;

interface WhatsappRepositoryInterface{
    public function add_points($data);
    public function get_user_points($user_id);
}
