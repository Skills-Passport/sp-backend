<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class ProfilesQuery
{
    public function filter(Builder $builder, $value): Builder
    {
        return $builder->whereHas('profiles', function (Builder $query) use ($value) {
            $query->where('profile_id', $value);
        });
    }
}
