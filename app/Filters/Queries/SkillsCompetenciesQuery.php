<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class SkillsCompetenciesQuery
{
    public function filter($builder, $value): Builder
    {
        $value = explode(',', $value);

        return $builder->whereHas('skill.competency', function (Builder $query) use ($value) {
            $query->whereIn('competency_id', $value);
        });
    }
}
