<?php

namespace App\Filters;

use App\Filters\Queries\CompetenciesQuery;
use App\Filters\Queries\IsAddedQuery;
use App\Filters\Queries\TitleQuery;

class SkillFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleQuery::class,
        'competencies' => CompetenciesQuery::class,
        'is_added' => IsAddedQuery::class,
    ];
}
