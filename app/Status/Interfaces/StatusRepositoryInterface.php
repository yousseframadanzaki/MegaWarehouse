<?php

namespace App\Status\Interfaces;

interface StatusRepositoryInterface{
    public function update_status($status_id,$edit_order);
    public function update_related_shipping($data);
    public function add_related_status($status_id,$related_status);
    public function remove_related_status($related_status, $status_id);
    public function update_status_color($data);
}
