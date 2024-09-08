<?php

namespace App\Dashboard\Services;

use App\Dashboard\Interfaces\DashboardRepositoryInterface;
use App\Dashboard\Interfaces\DashboardServiceInterface;

class DashboardService implements DashboardServiceInterface
{
    public function __construct(
        protected readonly DashboardRepositoryInterface $DashboardRepository,
    ) {
    }

    public function GetCityOrdersCount()
    {
        $cities_data = $this->DashboardRepository->get_city_orders_count();
        $total_orders = $cities_data->pluck('count')->sum();

        $data = [
            'city' => array_fill(0, 28, ''),
            'count' => array_fill(0, 28, ''),
            'color' => array_fill(0, 28, '#ffffff'),
            'border-color' => array_fill(0, 28, '#ffffff')
        ];

        $index = 0;
        foreach($cities_data as $city_data){
            $city_orders =  round($city_data->count * 100.0 / $total_orders);
            $data['city'][$index] = '%' . $city_data->city . ' - ' . $city_orders;
            $data['count'][$index] = $city_data->count;
            $data['color'][$index] = $this->getColor($index)[0];
            $data['border-color'][$index] = $this->getColor($index)[1];
            $index++;
        }

        return $data;
    }

    public function GetStatusOrdersCount() {
        $status_orders_data = $this->DashboardRepository->get_status_orders_count();
        return [
            'names' => $status_orders_data->pluck('name'),
            'orders_count' => $status_orders_data->pluck('orders_count'),
        ];
    }

    function getColor($index) {
        $cssColors = [
            'rgba(255, 0, 0, 0.2)', 'rgba(0, 255, 0, 0.2)', 'rgba(0, 0, 255, 0.2)', 'rgba(255, 255, 0, 0.2)',
            'rgba(255, 0, 255, 0.2)', 'rgba(0, 255, 255, 0.2)', 'rgba(128, 0, 0, 0.2)', 'rgba(0, 128, 0, 0.2)',
            'rgba(0, 0, 128, 0.2)', 'rgba(128, 128, 0, 0.2)', 'rgba(128, 0, 128, 0.2)', 'rgba(0, 128, 128, 0.2)',
            'rgba(255, 128, 0, 0.2)', 'rgba(255, 0, 128, 0.2)', 'rgba(128, 255, 0, 0.2)', 'rgba(128, 0, 255, 0.2)',
            'rgba(0, 128, 255, 0.2)', 'rgba(0, 255, 128, 0.2)', 'rgba(255, 128, 128, 0.2)', 'rgba(128, 255, 128, 0.2)',
            'rgba(128, 128, 255, 0.2)', 'rgba(255, 255, 128, 0.2)', 'rgba(255, 128, 255, 0.2)', 'rgba(128, 255, 255, 0.2)',
            'rgba(192, 0, 0, 0.2)', 'rgba(0, 192, 0, 0.2)', 'rgba(0, 0, 192, 0.2)', 'rgba(192, 192, 0, 0.2)',
            'rgba(192, 0, 192, 0.2)', 'rgba(0, 192, 192, 0.2)', 'rgba(255, 192, 0, 0.2)', 'rgba(255, 0, 192, 0.2)',
            'rgba(192, 255, 0, 0.2)', 'rgba(192, 0, 255, 0.2)', 'rgba(0, 192, 255, 0.2)', 'rgba(0, 255, 192, 0.2)',
            'rgba(255, 192, 192, 0.2)', 'rgba(192, 255, 192, 0.2)', 'rgba(192, 192, 255, 0.2)', 'rgba(255, 255, 192, 0.2)',
            'rgba(255, 192, 255, 0.2)', 'rgba(192, 255, 255, 0.2)', 'rgba(224, 0, 0, 0.2)', 'rgba(0, 224, 0, 0.2)',
            'rgba(0, 0, 224, 0.2)', 'rgba(224, 224, 0, 0.2)', 'rgba(224, 0, 224, 0.2)', 'rgba(0, 224, 224, 0.2)',
            'rgba(255, 224, 0, 0.2)', 'rgba(255, 0, 224, 0.2)', 'rgba(224, 255, 0, 0.2)', 'rgba(224, 0, 255, 0.2)',
            'rgba(0, 224, 255, 0.2)', 'rgba(0, 255, 224, 0.2)', 'rgba(255, 224, 224, 0.2)', 'rgba(224, 255, 224, 0.2)',
            'rgba(224, 224, 255, 0.2)', 'rgba(255, 255, 224, 0.2)', 'rgba(255, 224, 255, 0.2)', 'rgba(224, 255, 255, 0.2)',
            'rgba(160, 0, 0, 0.2)', 'rgba(0, 160, 0, 0.2)', 'rgba(0, 0, 160, 0.2)', 'rgba(160, 160, 0, 0.2)',
            'rgba(160, 0, 160, 0.2)', 'rgba(0, 160, 160, 0.2)', 'rgba(255, 160, 0, 0.2)', 'rgba(255, 0, 160, 0.2)',
            'rgba(160, 255, 0, 0.2)', 'rgba(160, 0, 255, 0.2)', 'rgba(0, 160, 255, 0.2)', 'rgba(0, 255, 160, 0.2)',
            'rgba(255, 160, 160, 0.2)', 'rgba(160, 255, 160, 0.2)', 'rgba(160, 160, 255, 0.2)', 'rgba(255, 255, 160, 0.2)',
            'rgba(255, 160, 255, 0.2)', 'rgba(160, 255, 255, 0.2)', 'rgba(128, 0, 0, 0.2)', 'rgba(0, 128, 0, 0.2)',
            'rgba(0, 0, 128, 0.2)', 'rgba(128, 128, 0, 0.2)', 'rgba(128, 0, 128, 0.2)', 'rgba(0, 128, 128, 0.2)',
            'rgba(255, 128, 0, 0.2)', 'rgba(255, 0, 128, 0.2)', 'rgba(128, 255, 0, 0.2)', 'rgba(128, 0, 255, 0.2)',
            'rgba(0, 128, 255, 0.2)', 'rgba(0, 255, 128, 0.2)', 'rgba(255, 128, 128, 0.2)', 'rgba(128, 255, 128, 0.2)',
            'rgba(128, 128, 255, 0.2)', 'rgba(255, 255, 128, 0.2)', 'rgba(255, 128, 255, 0.2)', 'rgba(128, 255, 255, 0.2)'
        ];

        $cssBorders = [
            'rgba(255, 0, 0, 1)', 'rgba(0, 255, 0, 1)', 'rgba(0, 0, 255, 1)', 'rgba(255, 255, 0, 1)',
            'rgba(255, 0, 255, 1)', 'rgba(0, 255, 255, 1)', 'rgba(128, 0, 0, 1)', 'rgba(0, 128, 0, 1)',
            'rgba(0, 0, 128, 1)', 'rgba(128, 128, 0, 1)', 'rgba(128, 0, 128, 1)', 'rgba(0, 128, 128, 1)',
            'rgba(255, 128, 0, 1)', 'rgba(255, 0, 128, 1)', 'rgba(128, 255, 0, 1)', 'rgba(128, 0, 255, 1)',
            'rgba(0, 128, 255, 1)', 'rgba(0, 255, 128, 1)', 'rgba(255, 128, 128, 1)', 'rgba(128, 255, 128, 1)',
            'rgba(128, 128, 255, 1)', 'rgba(255, 255, 128, 1)', 'rgba(255, 128, 255, 1)', 'rgba(128, 255, 255, 1)',
            'rgba(192, 0, 0, 1)', 'rgba(0, 192, 0, 1)', 'rgba(0, 0, 192, 1)', 'rgba(192, 192, 0, 1)',
            'rgba(192, 0, 192, 1)', 'rgba(0, 192, 192, 1)', 'rgba(255, 192, 0, 1)', 'rgba(255, 0, 192, 1)',
            'rgba(192, 255, 0, 1)', 'rgba(192, 0, 255, 1)', 'rgba(0, 192, 255, 1)', 'rgba(0, 255, 192, 1)',
            'rgba(255, 192, 192, 1)', 'rgba(192, 255, 192, 1)', 'rgba(192, 192, 255, 1)', 'rgba(255, 255, 192, 1)',
            'rgba(255, 192, 255, 1)', 'rgba(192, 255, 255, 1)', 'rgba(224, 0, 0, 1)', 'rgba(0, 224, 0, 1)',
            'rgba(0, 0, 224, 1)', 'rgba(224, 224, 0, 1)', 'rgba(224, 0, 224, 1)', 'rgba(0, 224, 224, 1)',
            'rgba(255, 224, 0, 1)', 'rgba(255, 0, 224, 1)', 'rgba(224, 255, 0, 1)', 'rgba(224, 0, 255, 1)',
            'rgba(0, 224, 255, 1)', 'rgba(0, 255, 224, 1)', 'rgba(255, 224, 224, 1)', 'rgba(224, 255, 224, 1)',
            'rgba(224, 224, 255, 1)', 'rgba(255, 255, 224, 1)', 'rgba(255, 224, 255, 1)', 'rgba(224, 255, 255, 1)',
            'rgba(160, 0, 0, 1)', 'rgba(0, 160, 0, 1)', 'rgba(0, 0, 160, 1)', 'rgba(160, 160, 0, 1)',
            'rgba(160, 0, 160, 1)', 'rgba(0, 160, 160, 1)', 'rgba(255, 160, 0, 1)', 'rgba(255, 0, 160, 1)',
            'rgba(160, 255, 0, 1)', 'rgba(160, 0, 255, 1)', 'rgba(0, 160, 255, 1)', 'rgba(0, 255, 160, 1)',
            'rgba(255, 160, 160, 1)', 'rgba(160, 255, 160, 1)', 'rgba(160, 160, 255, 1)', 'rgba(255, 255, 160, 1)',
            'rgba(255, 160, 255, 1)', 'rgba(160, 255, 255, 1)', 'rgba(128, 0, 0, 1)', 'rgba(0, 128, 0, 1)',
            'rgba(0, 0, 128, 1)', 'rgba(128, 128, 0, 1)', 'rgba(128, 0, 128, 1)', 'rgba(0, 128, 128, 1)',
            'rgba(255, 128, 0, 1)', 'rgba(255, 0, 128, 1)', 'rgba(128, 255, 0, 1)', 'rgba(128, 0, 255, 1)',
            'rgba(0, 128, 255, 1)', 'rgba(0, 255, 128, 1)', 'rgba(255, 128, 128, 1)', 'rgba(128, 255, 128, 1)',
            'rgba(128, 128, 255, 1)', 'rgba(255, 255, 128, 1)', 'rgba(255, 128, 255, 1)', 'rgba(128, 255, 255, 1)'
        ];

        return [$cssColors[$index], $cssBorders[$index]];
    }
}

