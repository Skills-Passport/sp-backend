<?php

namespace App\Filters;

class CompetencyFilter
{
    public function filter($builder, $value)
    {
        $value = explode(',', $value);
        return $builder->whereIn('competency_id', $value);
    }
}