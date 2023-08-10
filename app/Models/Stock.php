<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $fillable = [
        'warehouse_id',
        'variant_id',
        'admin_id',
        'company_id',
        'order_id',
        'note',
        'type',
        'quantity',
    ];

    function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function variant()
    {
        return $this->belongsTo(Variant::class);
    }

    public function image()
    {
        return $this->hasOne(Media::class,'collection_id')->where('collection','stock');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }
}
