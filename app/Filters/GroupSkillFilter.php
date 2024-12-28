<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GroupSkillFilter extends AbstractFilter
{
    protected $filters = [
        'skills' => OnSkillFilter::class,
    ];
}