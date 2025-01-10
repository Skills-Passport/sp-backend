<?php

namespace App\Filters;

use App\Filters\Queries\FirstNameQuery;
use App\Filters\Queries\RoleQuery;

class UserFilter extends AbstractFilter
{
    protected $filters = [
        'search' => FirstNameQuery::class,
        'roles' => RoleQuery::class,
    ];
}
