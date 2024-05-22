<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
class Status extends Model
{
    use HasFactory;
    use EagerLoadPivotTrait;

    public function getRelatedStatusesNames()
    {
        if ($this->related_status) {
            $relatedStatusIds = explode(',', $this->related_status);
            return self::whereIn('id', $relatedStatusIds)->pluck('name')->toArray();
        }
        return [];
    }
}
