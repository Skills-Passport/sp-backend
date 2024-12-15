<?php

namespace App\Filters;

class SkillFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleFilter::class,
        'competencies' => ProfileCompetencyFilter::class,
        'is_added' => IsAddedFilter::class,
    ];
}
