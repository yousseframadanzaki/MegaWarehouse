<?php

namespace App\Dashboard\Repositories;

use Illuminate\Support\Facades\DB;
use App\Dashboard\Interfaces\DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface{

    public function get_city_orders_count(){
        $user = auth()->user();
        return DB::table('orders')
            ->join('cities', 'cities.id', '=', 'orders.city_id')
            ->select('cities.name AS city', DB::raw('COUNT(orders.id) AS count'))
            ->where('orders.company_id', '=', "$user->company_id")
            ->groupBy('cities.id', 'cities.name')
            ->get();
    }
}
