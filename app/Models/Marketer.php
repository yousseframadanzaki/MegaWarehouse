<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marketer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'page_name',
        'phone_number',
        'links',
        'company_id',
    ];
}
