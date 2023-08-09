<?php

namespace App\Orders\Filters;

use App\Orders\Filters\OrderCodeFilter;
use App\Orders\Filters\ClientFilter;
use App\Orders\Filters\StatusFilter;
use App\Orders\Filters\CityFilter;
use App\Orders\Filters\AreaFilter;
use App\Orders\Filters\DateFromFilter;
use App\Orders\Filters\DateToFilter;

class OrdersFilters
{

    protected $filters = [
        'order_code' => OrderCodeFilter::class,
        'client_id' => ClientFilter::class,
        'status_id' => StatusFilter::class,
        'city_id'   => CityFilter::class,
        'area_id'   => AreaFilter::class,
        'date_from' => DateFromFilter::class,
        'date_to'   => DateToFilter::class,
    ];


    public function apply($query)
    {
        foreach ($this->receivedFilters() as $name => $value) {
            $filterInstance = new $this->filters[$name];
            $query = $filterInstance($query, $value);
        }

        return $query;
    }


    public function receivedFilters()
    {
        return request()->only(array_keys($this->filters));
    }
}