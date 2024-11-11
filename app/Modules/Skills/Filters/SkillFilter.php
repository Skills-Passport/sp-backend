<?php

namespace App\Modules\Skills\Filters;

use App\Filters\AbstractFilter;
use App\Modules\Skills\Filters\SearchFilter;
use App\Modules\Skills\Filters\IsAddedFilter;
use App\Modules\Skills\Filters\CompetencyFilter;

class SkillFilter extends AbstractFilter
{
    protected $filters = [
        'search' => SearchFilter::class,
        'competencies' => CompetencyFilter::class,
        'is_added' => IsAddedFilter::class,
    ];
}

