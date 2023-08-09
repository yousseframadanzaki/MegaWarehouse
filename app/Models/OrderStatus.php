<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use App\Models\Media;

class OrderStatus extends Pivot
{
    use HasFactory;
    public $incrementing = true;
    protected $table = 'order_status';

    public function admin() {
        return $this->belongsTo(User::class,'admin_id');
    }

    public function order() {
        return $this->belongsTo(Order::class,'order_id');
    }

    public function status() {
        return $this->belongsTo(Status::class,'status_id');
    }

    public function images() {
        return $this->hasMany(Media::class,'collection_id')->where('collection','order_status');
    }

}
