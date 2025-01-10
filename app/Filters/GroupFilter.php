<?php

namespace App\Filters;

use App\Filters\Queries\IsJoinedQuery;
use App\Filters\Queries\GroupsSearchQuery;

class GroupFilter extends AbstractFilter
{
    protected $filters = [
        'search' => GroupsSearchQuery::class,
        'is_joined' => IsJoinedQuery::class,
    ];
}
