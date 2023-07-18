<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id'
    ];

    public function logo() {
        return $this->hasOne(Media::class,'collection_id')->where('collection','brand')->latestOfMany();
    }

}
