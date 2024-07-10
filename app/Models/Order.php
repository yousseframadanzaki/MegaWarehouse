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
use App\Models\ShippingCompany;
use App\Models\Marketer;
use App\Models\Company;
use App\Models\OrderNotes;

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
        'delivery_cost',
        'total',
        'total_after_sale',
        'client_id',
        'company_id',
        'status_id',
        'admin_id',
        'order_code',
        'waybill',
        'payment_id',
        'shipping_company_id',
        'shipping_co_cost',
        'total_marketer_commission',
        'marketer_id',
    ];

    public function items()
    {
        return $this->belongsToMany(Variant::class, 'orders_items','orders_id','variants_id')
        ->using(OrderItem::class)
        ->withPivot('warehouse_id', 'quantity');
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
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

    public function marketer()
    {
        return $this->belongsTo(Marketer::class);
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

    public function shipping_company()
    {
        return $this->belongsTo(ShippingCompany::class);
    }
    public function companies()
    {
        return $this->belongsTo(Company::class ,'company_id');
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
    public function order_notes()
    {
        return $this->hasMany(OrderNotes::class, 'order_id');
    }
    public function order_data()
    {
        return $this->hasOne(OrderData::class);
    }
}
