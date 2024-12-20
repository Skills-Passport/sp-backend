<?php

namespace App\Filters;

class CompetenciesFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleFilter::class,
        'profile' => OnProfileFilter::class,
    ];
}
