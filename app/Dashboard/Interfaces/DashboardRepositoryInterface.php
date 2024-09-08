<?php

namespace App\Dashboard\Interfaces;

interface DashboardRepositoryInterface{
    public function get_city_orders_count();
    public function get_status_orders_count();
}
