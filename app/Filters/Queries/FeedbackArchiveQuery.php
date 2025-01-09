<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class FeedbackArchiveQuery
{
    public function filter(Builder $builder, $value)
    {
        if ($value === 'true') {
            return $builder->where('status', 'answered');
        } elseif ($value === 'false') {
            return $builder->where('status', 'pending');
        }

        return $builder;
    }
}
