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
}
