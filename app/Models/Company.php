<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\Order;

class Company extends Model
{
    protected $fillable = [
        'name',
        'company_type',
        'max_users',
        'max_orders',
        'owner_id',
        'code',
    ];
    use HasFactory;

    public function users():HasMany {
        return $this->hasMany(User::class);
    }

    /**
     * Get all of the roles for the Company
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(Role::class, 'company_id');
        return $this->hasMany(Order::class, 'company_id');
    }

}
