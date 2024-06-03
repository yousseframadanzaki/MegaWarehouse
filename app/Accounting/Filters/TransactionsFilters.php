<?php

namespace App\Accounting\Filters;

use App\Accounting\Filters\DateFromFilter;
use App\Accounting\Filters\DateToFilter;
use App\Accounting\Filters\FromUserFilter;
use App\Accounting\Filters\ToUserFilter;
use App\Accounting\Filters\InvoiceFilter;
use App\Accounting\Filters\OrderCodeFilter;
use App\Accounting\Filters\PaymentTypeFilter;
use App\Accounting\Filters\TransactionCodeFilter;

use App\Models\User;
use App\Models\PaymentType;

class TransactionsFilters
{

    protected $filters = [
        'transaction_code' => TransactionCodeFilter::class,
        'date_from' => DateFromFilter::class,
        'date_to' => DateToFilter::class,
        'from_user' => FromUserFilter::class,
        'to_user' => ToUserFilter::class,
        'invoice_id' => InvoiceFilter::class,
        'order_code' => OrderCodeFilter::class,
        'payment_type_id' => PaymentTypeFilter::class,
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
        $filters = request()->only(array_keys($this->filters));
        $filtered = array_filter($filters, function($value) {
            return !is_null($value);
        });

        return $filtered;
    }

    public function get_values() {
        $filters = $this->receivedFilters();
        foreach ($filters as $key => $value) {
            if ($key == 'payment_type_id') {
                $filters['payment_type_id'] = PaymentType::findOrfail($value)->name;
            }
            if($key == 'from_user'){
                $filters['from_user'] = User::findOrfail($value)->name;
                continue;
            }
            if($key == 'to_user'){
                $filters['to_user'] = User::findOrfail($value)->name;
                continue;
            }
        }
        return $filters;
    }

}
