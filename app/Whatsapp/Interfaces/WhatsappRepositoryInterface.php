<?php

namespace App\Whatsapp\Interfaces;

interface WhatsappRepositoryInterface{
    public function add_points($data);
    public function get_campaigns($company_id);
    public function change_campaign_status($campaign_id,$status);
    public function get_user_points($user_id);
    public function get_devices($user_id);
    public function add_device($data);
    public function delete_device($device_id);
    public function store_campagin($data);
}
