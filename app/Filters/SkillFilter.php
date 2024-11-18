<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\SearchFilter;
use App\Filters\CompetencyFilter;
use App\Filters\IsAddedFilter;
class SkillFilter extends AbstractFilter
{
    protected $filters = [
        'search' => SearchFilter::class,
        'competencies' => CompetencyFilter::class,
        'is_added' => IsAddedFilter::class,
    ];
}

