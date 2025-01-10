<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class GroupsSearchQuery
{
    public function filter(Builder $builder, string $value): Builder
    {
        return $builder->where('name', 'like', "%{$value}%")->orWhereHas('teachers', function ($query) use ($value) {
            $query->where('first_name', 'like', "%{$value}%")->orWhere('last_name', 'like', "%{$value}%");
        });
    }
}