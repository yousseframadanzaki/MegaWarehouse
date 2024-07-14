<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name_ar',
        'name_en',
        'route',
        'icon',
        'resource',
        'permissions',
        'sort',
        'active'
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function children()
    {
        return $this->hasMany(Link::class, 'parent_id')->orderBy('sort');
    }

    public function parent()
    {
        return $this->belongsTo(Link::class, 'parent_id');
    }
}