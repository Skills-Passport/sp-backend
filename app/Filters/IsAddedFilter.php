<?php

namespace App\Filters;

class IsAddedFilter
{
    public function filter($builder, $value)
    {
        if ($value == 'true')
            return $builder->whereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            });
        else if ($value == 'false')
            return $builder->whereDoesntHave('users', function ($query) {
                $query->where('user_id', auth()->id());
            });

        return $builder;
    }
}