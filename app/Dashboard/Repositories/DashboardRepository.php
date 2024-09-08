<?php

namespace App\Dashboard\Repositories;

use App\Models\Status;

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

    public function get_status_orders_count() {
        $status_ids = [1, 2, 3, 5, 6, 7, 13, 30, 33, 35];
        return Status::whereIn('id', $status_ids)
        ->withCount(['orders' => function($query) {
            $query->where('company_id', auth()->user()->company_id);
        }])
        ->get();
    }
}
