<?php

namespace App\Modules\Skills\Filters;

class SearchFilter
{
    public function filter($builder, $value)
    {
        return $builder->where('title', 'like', '%' . $value . '%');
    }
}