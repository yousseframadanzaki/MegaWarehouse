<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Area;

class ShippingArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'area_id',
        'shipping_company_sector_id',
        'shipping_company_id'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

}
