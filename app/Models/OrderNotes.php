<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class OrderNotes extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_id',
        'admin_id',
        'note',
        'company_id',
        'active'
    ];

    public function orders()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
