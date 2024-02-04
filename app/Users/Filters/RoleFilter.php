<?php

namespace App\Users\Filters;

class RoleFilter
{
    function __invoke($query, $role_id)
    {
        return $query->where('role_id',$role_id);
    }
}