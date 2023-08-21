<?php

namespace App\Orders\Filters;

use App\Orders\Filters\OrderCodeFilter;
use App\Orders\Filters\ClientFilter;
use App\Orders\Filters\StatusFilter;
use App\Orders\Filters\CityFilter;
use App\Orders\Filters\AreaFilter;
use App\Orders\Filters\DateFromFilter;
use App\Orders\Filters\DateToFilter;
use App\Orders\Filters\MarketerFilter;
use App\Orders\Filters\ShippingCompanyFilter;
use App\Orders\Filters\WaybillFilter;

use App\Models\Client;
use App\Models\Status;
use App\Models\City;
use App\Models\Area;
use App\Models\Marketer;
use App\Models\ShippingCompany;

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
        'marketer_id'   => MarketerFilter::class,
        'shipping_company_id'   => ShippingCompanyFilter::class,
        'waybill'   => WaybillFilter::class,
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

    public function get_values() {
        $filters = $this->receivedFilters();
        foreach ($filters as $key => $value) {
            if($key == 'client_id'){
                $filters['client_id'] = Client::findOrfail($value)->name;
                continue;
            }
            if($key == 'status_id'){
                $filters['status_id'] = Status::findOrfail($value)->name;
                continue;
            }
            if($key == 'city_id'){
                $filters['city_id'] = City::findOrfail($value)->name;
                continue;
            }
            if($key == 'area_id'){
                $filters['area_id'] = Area::findOrfail($value)->name;
                continue;
            }
            if($key == 'marketer_id'){
                $filters['marketer_id'] = Marketer::findOrfail($value)->name;
                continue;
            }
            if($key == 'shipping_company_id'){
                $filters['shipping_company_id'] = ShippingCompany::findOrfail($value)->name;
                continue;
            }
        }
        return $filters;
    }

}