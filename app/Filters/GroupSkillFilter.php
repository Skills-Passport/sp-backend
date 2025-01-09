<?php

namespace App\Filters;

use App\Filters\Queries\SkillQuery;

class GroupSkillFilter extends AbstractFilter
{
    protected $filters = [
        'skills' => SkillQuery::class,
    ];
}
