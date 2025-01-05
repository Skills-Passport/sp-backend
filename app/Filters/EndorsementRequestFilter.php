<?php

namespace App\Filters;

use App\Filters\AbstractFilter;
use App\Filters\Queries\EndorsementRequestTypeQuery;
use App\Filters\Queries\EndorsmentRequestArchiveQuery;


class EndorsementRequestFilter extends AbstractFilter
{
    protected $filters = [
        'type' => EndorsementRequestTypeQuery::class,
        'is_archived' => EndorsmentRequestArchiveQuery::class,
    ];
}