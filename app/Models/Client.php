<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ClientGroup;
class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_1',
        'phone_2',
        'address',
        'country_id',
        'city_id',
        'area_id',
        'links',
        'client_group_id',
        'company_id',
        'location'
    ];

    public function getLinksAttribute($links)
    {
        return json_decode($links);
    }


    public function client_group() {
        return $this->belongsTo(ClientGroup::class);
    }

    public function area() {
        return $this->belongsTo(Area::class);
    }
}
