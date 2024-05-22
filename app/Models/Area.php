<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\City;
use App\Models\ShippingCompany;

class Area extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'city_id',
        'shipping_company_id',
        'keywords',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function shipping_company()
    {
        return $this->belongsTo(ShippingCompany::class);
    }
}
