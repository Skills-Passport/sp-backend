<?php

namespace App\Filters;

use App\Filters\Queries\IsJoinedQuery;
use App\Filters\Queries\NameQuery;

class GroupFilter extends AbstractFilter
{
    protected $filters = [
        'search' => NameQuery::class,
        'is_joined' => IsJoinedQuery::class,
    ];
}
