<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'shipping_company_id',
        'total_cod',
        'total_shipping_cost',
        'orders_qty'
    ];

    public function shipping_company() {
        return $this->belongsTo(ShippingCompany::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
