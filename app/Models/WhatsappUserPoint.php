<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappUserPoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'admin_id',
        'user_id',
        'campaign_id',
        'messages',
        'points',
        'type',
        'note',
        'expire_date',
        'created_at',
        'updated_at',
    ];
}
