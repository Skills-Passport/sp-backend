<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Queries\NameQuery;
use App\Filters\Queries\IsJoinedQuery;


class GroupFilter extends AbstractFilter
{
    protected $filters = [
        'search' => NameQuery::class,
        'is_joined' => IsJoinedQuery::class,
    ];
}
