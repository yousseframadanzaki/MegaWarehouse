<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'values',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function variants() {
        return $this->belongsToMany(Variant::class,'variants_attributes','attribute_id','variant_id')->withPivot('value');
    }

}
