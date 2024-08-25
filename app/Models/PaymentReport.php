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
        'orders_qty',
        'note'
    ];

    public function shipping_company() {
        return $this->belongsTo(ShippingCompany::class);
    }

    public function image() {
        return $this->hasOne(Media::class,'collection_id')->where('collection','payment_reports')->latestOfMany();
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }

    public function transaction() {
        return $this->hasOne(Transaction::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
