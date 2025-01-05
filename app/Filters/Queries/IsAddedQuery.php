<?php

namespace App\Filters\Queries;

class IsAddedQuery
{
    public function filter($builder, $value)
    {
        if ($value == 'true') {
            return $builder->whereHas('users', function ($query) {
                $query->where('user_id', auth()->id());
            });
        } elseif ($value == 'false') {
            return $builder->whereDoesntHave('users', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

        return $builder;
    }
}
