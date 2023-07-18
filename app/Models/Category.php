<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

}
