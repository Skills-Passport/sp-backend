<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class NameQuery
{
    public function filter(Builder $builder, string $value): Builder
    {
        return $builder->where('first_name', 'like', "%{$value}%")
            ->orWhere('last_name', 'like', "%{$value}%");
    }
}
