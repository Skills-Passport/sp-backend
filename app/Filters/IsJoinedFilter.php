<?php

namespace App\Filters;

class IsJoinedFilter
{
    public function filter($builder, $value)
    {
        if ($value == 'true') {
            return $builder->whereHas('students', function ($query) {
                $query->where('user_id', auth()->id());
            })->orWhereHas('teachers', function ($query) {
                $query->where('user_id', auth()->id());
            });
        } elseif ($value == 'false') {
            return $builder->whereDoesntHave('students', function ($query) {
                $query->where('user_id', auth()->id());
            })->whereDoesntHave('teachers', function ($query) {
                $query->where('user_id', auth()->id());
            });
        }

        return $builder;
    }
}
