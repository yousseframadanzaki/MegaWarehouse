<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Models\Variant;

class Order extends Pivot
{
    protected $fillable = [
        'name',
        'phone_1',
        'phone_2',
        'address',
        'country_id',
        'city_id',
        'area_id',
        'total',
        'client_id',
        'company_id',
        'status_id',
        'admin_id',
    ];

    
    public function items()
    {
        return $this->belongsToMany(Variant::class, 'orders_items', 'orders_id', 'variants_id');
    }

}
