<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
class Variant extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;
    protected $fillable = [
        'name',
        'quantity',
        'sku',
        'price',
        'shelf_num',
        'is_default',
        'product_id',
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function attributes() {
        return $this->belongsToMany(Attribute::class,'variants_attributes','variant_id','attribute_id')->withPivot('value');
    }

}
