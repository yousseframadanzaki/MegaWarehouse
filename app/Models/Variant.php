<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'sku',
        'price',
        'is_default',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class,'variants_attributes','variant_id','attribute_id');
    }

}
