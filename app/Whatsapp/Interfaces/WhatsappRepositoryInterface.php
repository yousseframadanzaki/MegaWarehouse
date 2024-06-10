<?php

namespace App\Whatsapp\Interfaces;

interface WhatsappRepositoryInterface{
    public function add_points($data);
    public function get_user_points($user_id);
    public function get_devices($user_id);
    public function add_device($data);
    public function delete_device($device_id);
}
