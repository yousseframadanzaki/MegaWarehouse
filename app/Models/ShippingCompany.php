<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingCompany extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'username',
        'password',
        'url',
        'mega_company_id',
        'company_id',
        'user_id',
    ];

    public function statues() {
        return $this->belongsToMany(Status::class, 'shipping_statuses');
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
