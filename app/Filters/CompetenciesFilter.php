<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Queries\TitleQuery;
use App\Filters\Queries\ProfilesQuery;


class CompetenciesFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleQuery::class,
        'profile' => ProfilesQuery::class,
    ];
}
