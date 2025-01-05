<?php

namespace App\Filters\Queries;

use App\Filters\AbstractFilter;
use App\Filters\Queries\FeedbackArchiveQuery;

class FeedbackRequestFilter extends AbstractFilter
{
    protected $filters = [
        'is_archived' => FeedbackArchiveQuery::class,
    ];
}