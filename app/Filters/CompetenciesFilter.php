<?php

namespace App\Filters;

use App\Filters\TitleFilter;

class CompetenciesFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleFilter::class,
    ];
}