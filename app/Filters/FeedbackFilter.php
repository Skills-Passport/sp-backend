<?php

namespace App\Filters;

use App\Filters\Queries\TitleQuery;

class FeedbackFilter extends AbstractFilter
{
    protected $filters = [
        'search' => TitleQuery::class,
        'is_archived' => FeedbackArchiveQuery::class,
    ];
}
