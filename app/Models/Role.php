<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\Permission;
use App\Models\Company;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
    ];

    
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function permissions() {
        return $this->belongsToMany(Permission::class, 'roles_permissions','roles_id','permissions_id');
    }

    /**
     * Get the company that owns the Role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

}
