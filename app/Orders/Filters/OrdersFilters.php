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
use App\Orders\Filters\ProductFilter;
use App\Orders\Filters\VariantFilter;
use App\Orders\Filters\AdminFilter;
use App\Orders\Filters\OrderIdFilter;

use App\Models\Client;
use App\Models\User;
use App\Models\Status;
use App\Models\City;
use App\Models\Area;
use App\Models\Marketer;
use App\Models\Product;
use App\Models\ShippingCompany;
use App\Models\Variant;

class OrdersFilters
{

    protected $filters = [
        'order_ids' => OrderIdFilter::class,
        'order_code' => OrderCodeFilter::class,
        'client_id' => ClientFilter::class,
        'status_id' => StatusFilter::class,
        'city_id'   => CityFilter::class,
        'area_id'   => AreaFilter::class,
        'product_id'   => ProductFilter::class,
        'variant_id'   => VariantFilter::class,
        'date_from' => DateFromFilter::class,
        'date_to'   => DateToFilter::class,
        'marketer_id'   => MarketerFilter::class,
        'shipping_company_id'   => ShippingCompanyFilter::class,
        'waybill'   => WaybillFilter::class,
        'admin_id' => AdminFilter::class,
        'date_type' => '',
    ];


    public function apply($query)
    {
        $receivedFilters = $this->receivedFilters();
        foreach ($receivedFilters as $name => $value) {
            if ($name == 'date_type')
                continue;

            $filterInstance = new $this->filters[$name];
            if ($name == 'date_from' || $name == 'date_to')
                $value .= ('|' . (!empty($receivedFilters['date_type']) ? $receivedFilters['date_type'] : 'الاوردرات'));

            $query = $filterInstance($query, $value);
        }

        return $query;
    }


    public function receivedFilters()
    {
        $filters = request()->only(array_keys($this->filters));
        $filtered = array_filter($filters, function($value) {
            return !is_null($value);
        });
        return $filtered;
    }

    public function get_values() {
        $filters = $this->receivedFilters();
        foreach ($filters as $key => $value) {
            if($key == 'client_id'){
                $filters['client_id'] = Client::findOrfail($value)->name;
                continue;
            }
            if($key == 'status_id') {
                $status_ids = explode(",", $value);
                $status_names = [];
                foreach ($status_ids as $status_id) {
                    $status = Status::findOrFail($status_id);
                    $status_names[] = $status->name;
                }
                $filters['status_id'] = implode(', ', $status_names);
                continue;
            }
            if($key == 'city_id'){
                $filters['city_id'] = str_replace(['"', '[', ']', ','], ['', '', '', ', '], json_encode(City::whereIn('id', explode(",", $value[0]))->pluck('name')->toArray(), JSON_UNESCAPED_UNICODE));
                continue;
            }
            if($key == 'area_id'){
                $filters['area_id'] = str_replace(['"', '[', ']', ','], ['', '', '', ', '], json_encode(Area::whereIn('id', explode(",", $value[0]))->pluck('name')->toArray(), JSON_UNESCAPED_UNICODE));
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
            if($key == 'product_id'){
                $filters['product_id'] = Product::findOrfail($value)->name;
                continue;
            }
            if($key == 'variant_id'){
                $filters['variant_id'] = Variant::findOrfail($value)->name;
                continue;
            }
            if($key == 'admin_id'){
                $filters['admin_id'] = User::findOrfail($value)->name;
            }
        }
        unset($filters['order_ids']);
        return $filters;
    }

}
