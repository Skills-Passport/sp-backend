<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class SkillQuery
{
    public function filter(Builder $builder, $value)
    {
        return $builder->whereHas('skills', function (Builder $query) use ($value) {
            $query->where('skill_id', $value);
        });
    }
}
