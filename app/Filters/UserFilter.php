<?php

namespace App\Filters;

use App\Filters\Queries\NameQuery;
use App\Filters\Queries\RoleQuery;


class UserFilter extends AbstractFilter
{
    protected $filters = [
        'search' => NameQuery::class,
        'roles' => RoleQuery::class,
    ];
}