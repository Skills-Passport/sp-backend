<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter
{
    public function filter(Builder $builder, string $value): Builder
    {
        return $builder->where('title', 'like', '%'.$value.'%');
    }
}
