<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

use App\Models\Order;
use App\Models\Warehouse;


class OrderItem extends Pivot
{
    public $incrementing = true;
    protected $table = 'orders_items';

    public function order() {
        return $this->belongsTo(Order::class,'orders_id');
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class,'warehouse_id');
    }

    public function variant() {
        return $this->belongsTo(Variant::class,'variants_id');
    }

}
