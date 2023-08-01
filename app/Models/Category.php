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

    protected $appends = ['parents_names'];


    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }


    public function getParentsNamesAttribute() {
        $parents_names = "";
        $parent = $this->parent;
        while(!is_null($parent)) {
            $parents_names .=  $parent->name . " - " ;
            $parent = $parent->parent;
        }
        $parents_names .= $this->name;
        return $parents_names;
    }

}
