<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class CompetenciesQuery
{
    public function filter($builder, $value): Builder
    {
        $value = explode(',', $value);

        return $builder->whereIn('competency_id', $value);
    }
}
