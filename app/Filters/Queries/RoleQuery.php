<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class RoleQuery
{
    public function filter(Builder $builder, string $value): Builder
    {
        $roles = explode(',', $value);

        return $builder->whereHas('roles', function (Builder $query) use ($roles) {
            return $query->whereIn('id', $roles);
        });
    }
}
