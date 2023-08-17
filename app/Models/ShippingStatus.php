<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Status;

class ShippingStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'shipping_company_status_id',
        'shipping_company_id',
    ];

    
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

}
