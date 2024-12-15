<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class EndorsementFilter extends AbstractFilter
{
    protected $filters = [
        'competency' => EndorsementCompetencyFilter::class,
    ];
} 