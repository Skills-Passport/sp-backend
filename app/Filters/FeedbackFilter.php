<?php

namespace App\Filters;

use Illuminate\Http\Request;

class FeedbackFilter extends AbstractFilter
{
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->filters = [
            'search' => TitleFilter::class,
        ];
    }
}