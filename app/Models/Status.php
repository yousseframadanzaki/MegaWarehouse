<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
class Status extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;

    protected $fillable = [
        'name',
        'related_status',
        'edit_order',
        'related_shipping',
        'show_all_orders',
        'color'
    ];

    public function getRelatedStatuses()
    {
        if ($this->related_status) {
            $relatedStatusIds = explode(',', $this->related_status);
            return self::whereIn('id', $relatedStatusIds)->get(['id', 'name'])->toArray();
        }
        return [];
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
