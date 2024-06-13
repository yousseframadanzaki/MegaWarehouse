<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Dashboard\Interfaces\DashboardServiceInterface;


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
        $data = $this->DashboardService->GetCityOrdersCount();
        return view('Dashboard.welcome',compact('data'));
    }
}
