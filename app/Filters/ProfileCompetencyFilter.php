<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class ProfileCompetencyFilter
{
    public function filter($builder, $value): Builder
    {
        $value = explode(',', $value);

        return $builder->whereIn('competency_id', $value);
    }
}
