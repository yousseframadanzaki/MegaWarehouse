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
}
