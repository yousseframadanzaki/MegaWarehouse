<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Company;
use App\Models\Media;
use App\Models\Warehouse;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone_1',
        'company_id',
        'active',
        'password',
        'is_admin',
        'role_id',
        'warehouse_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }

    public function permissions() {
        return $this->hasManyThrough(Permission::class,Role::class);
    }

    public function avatar() {
        return $this->hasOne(Media::class,'collection_id')->where('collection','avatars')->latestOfMany();
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function from_transactions()
    {
        return $this->hasMany(Transaction::class, 'from');
    }

    public function to_transactions()
    {
        return $this->hasMany(Transaction::class, 'to');
    }

    public function marketer()
    {
        return $this->hasOne(Marketer::class);
    }

    public function supplier()
    {
        return $this->hasOne(Supplier::class);
    }

    public function shipping_company() {
        return $this->hasOne(ShippingCompany::class);
    }
}
