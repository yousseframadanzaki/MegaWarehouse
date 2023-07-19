<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
class ClientGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'discount',
        'company_id',
    ];

    public function clients() {
        return $this->hasMany(Client::class,'client_group_id');
    }

}
