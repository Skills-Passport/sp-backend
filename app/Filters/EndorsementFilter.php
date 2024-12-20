<?php

namespace App\Filters;

class EndorsementFilter extends AbstractFilter
{
    protected $filters = [
        'competency' => EndorsementCompetencyFilter::class,
    ];
}
