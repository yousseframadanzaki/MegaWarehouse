<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Variant;
use App\Models\User;
use App\Models\Status;
use App\Models\City;
use App\Models\Area;
use App\Models\Client;
use App\Models\OrderItem;
use App\Models\OrderStatus;

class Order extends Model
{
    protected $table = 'orders';
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
        'order_code',
    ];
    public function items()
    {
        return $this->belongsToMany(Variant::class, 'orders_items','orders_id','variants_id')
        ->using(OrderItem::class)
        ->withPivot('warehouse_id', 'quantity');
    }

    public function order_status()
    {
        return $this->belongsToMany(Status::class)
        ->using(OrderStatus::class)
        ->withPivot('admin_id','note','current','id')
        ->withTimestamps()
        ->orderByPivot('created_at','desc');
    }

    
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
    
}
