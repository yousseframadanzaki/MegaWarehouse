<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappCampaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'order_ids',
        'user_id',
        'type',
        'admin_number',
        'unsent_numbers',
        'sent_numbers',
        'text',
        'media',
        'status',
        'delay',
        'next_time',
        'schedule_date',
    ];
}
