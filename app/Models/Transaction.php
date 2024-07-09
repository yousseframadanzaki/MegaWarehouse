<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'company_id',
        'from',
        'to',
        'order_id',
        'invoice_id',
        'commission',
        'note',
        'value',
        'delivery_cost',
        'payment_type_id',
        'admin_id',
    ];

    /**
     * Get the from that owns the Transaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from');
    }
    public function to_user()
    {
        return $this->belongsTo(User::class, 'to');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function payment_type()
    {
        return $this->belongsTo(PaymentType::class);
    }

    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
