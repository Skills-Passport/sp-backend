<?php

namespace App\Filters;

use App\Filters\Queries\ProfilesQuery;
use App\Filters\Queries\TitleQuery;

class CompetenciesFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleQuery::class,
        'profile' => ProfilesQuery::class,
    ];
}
