<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Queries\SkillsCompetenciesQuery;


class EndorsementFilter extends AbstractFilter
{
    protected $filters = [
        'competency' => SkillsCompetenciesQuery::class,
    ];
}
