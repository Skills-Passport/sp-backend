<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Queries\TitleQuery;
use App\Filters\Queries\IsAddedQuery;
use App\Filters\Queries\CompetenciesQuery;

class SkillFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleQuery::class,
        'competencies' => CompetenciesQuery::class,
        'is_added' => IsAddedQuery::class,
    ];
}
