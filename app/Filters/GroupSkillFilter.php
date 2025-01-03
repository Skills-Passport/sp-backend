<?php

namespace App\Filters;

class GroupSkillFilter extends AbstractFilter
{
    protected $filters = [
        'skills' => OnSkillFilter::class,
    ];
}