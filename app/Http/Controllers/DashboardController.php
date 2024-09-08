<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dashboard\Interfaces\DashboardServiceInterface;
use App\Models\Status;

class DashboardController extends Controller
{
    private DashboardServiceInterface $DashboardService;
    public function __construct(
        DashboardServiceInterface $DashboardService,
    )
    {
        $this->DashboardService = $DashboardService;
    }

    public function index() {
        $city_orders_data = $this->DashboardService->GetCityOrdersCount();
        $status_orders_data = $this->DashboardService->GetStatusOrdersCount();
        return view('Dashboard.welcome',compact('city_orders_data', 'status_orders_data'));
    }
}
