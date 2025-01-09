<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class EndorsmentRequestArchiveQuery
{
    public function filter(Builder $builder, $value)
    {
        if ($value === 'true') {
            return $builder->whereIn('status', ['approved', 'rejected']);
        } elseif ($value === 'false') {
            return $builder->whereNotIn('status', ['approved', 'rejected']);
        }

        return $builder;
    }
}
