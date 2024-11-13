<?php

namespace App\Filters;

class SearchFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('title', 'like', '%' . $value . '%');
    }
}