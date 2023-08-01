<?php

namespace App\Products\Filters;


class CategoryFilter
{
    function __invoke($query, $category_id)
    {
        return $query->whereHas('category', function ($query) use ($category_id) {
            $query->where('id', $category_id)->orWhere('parent_id',$category_id);
        });
    }
}
