<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone',
        'payment_methods',
        'contacts',
        'company_id',
        'user_id',
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

}
