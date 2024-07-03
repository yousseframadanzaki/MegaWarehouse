<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    use HasFactory;
    protected $table = 'order_data';
    protected $fillable = [
        'location',
        'service_type',
        'client_type',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
