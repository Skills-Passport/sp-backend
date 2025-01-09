<?php

namespace App\Filters\Queries;

use App\Filters\AbstractFilter;

class FeedbackRequestFilter extends AbstractFilter
{
    protected $filters = [
        'is_archived' => FeedbackArchiveQuery::class,
    ];
}
