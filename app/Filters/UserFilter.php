<?php

namespace App\Filters;

use App\Filters\NameQuery;

class UserFilter extends AbstractFilter
{
    protected $filters = [
        'search' => NameQuery::class,
    ];
}