<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class OnSkillFilter
{
    public function filter(Builder $builder, $value)
    {
        return $builder->whereHas('skills', function (Builder $query) use ($value) {
            $query->where('skill_id', $value);
        });
    }
}