<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Media;
class Product extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'company_id',
        'supplier_id',
        'brand_id',
        'category_id',
        'show_quantity',
        'confirm_order',
        'cost',
        'price',
        'before_sale_price',
        'marketer_commission',
        'is_bundle',
        'is_store',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function attributes() {
        return $this->hasMany(Attribute::class);
    }

    public function variants() {
        return $this->hasMany(Variant::class);
    }

    public function bundle_variants() {
        return $this->belongsToMany(Variant::class, 'bundles')->withPivot('price');
    }

    public function main_image() {
        return $this->hasOne(Media::class,'collection_id')->where('collection','product.main_image')->latest();
    }

    public function images() {
        return $this->hasMany(Media::class,'collection_id')->where('collection','product');
    }


    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }


}
