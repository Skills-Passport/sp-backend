<?php

namespace App\Filters;

class GroupFilter extends AbstractFilter
{
    protected $filters = [
        'search' => SearchFilter::class,
        'is_joined' => IsJoinedFilter::class,
    ];
}
