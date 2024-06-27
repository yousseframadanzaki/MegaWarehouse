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

    public function invoices() {
        return $this->hasMany(Invoice::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function image() {
        return $this->belongsTo(Media::class,'collection_id')->where('collection', 'supplier');
    }
}
