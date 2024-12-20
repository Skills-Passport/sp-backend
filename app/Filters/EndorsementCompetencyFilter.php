<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class EndorsementCompetencyFilter
{
    public function filter($builder, $value): Builder
    {
        $value = explode(',', $value);

        return $builder->whereHas('skill.competency', function (Builder $query) use ($value) {
            $query->whereIn('competency_id', $value);
        });
    }
}
