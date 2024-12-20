<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class OnProfileFilter
{
    public function filter(Builder $builder, $value)
    {
        return $builder->whereHas('profiles', function (Builder $query) use ($value) {
            $query->where('profile_id', $value);
        });
    }
}
