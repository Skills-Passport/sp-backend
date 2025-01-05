<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class TitleQuery
{
    public function filter(Builder $builder, string $value): Builder
    {
        return $builder->where('title', 'like', '%'.$value.'%');
    }
}
