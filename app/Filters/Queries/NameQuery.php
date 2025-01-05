<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class NameQuery
{
    public function filter(Builder $builder, string $value): Builder
    {
        return $builder->where('name', 'like', '%'.$value.'%');
    }
}
