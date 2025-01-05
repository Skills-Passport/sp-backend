<?php

namespace App\Filters\Queries;

use Illuminate\Database\Eloquent\Builder;

class EndorsementRequestTypeQuery
{
    public function filter(Builder $builder, $value)
    {
        if ($value === 'review') {
            return $builder->where('requestee_email', '!=', null)->where('status', 'filled');
        } elseif ($value === 'request') {
            return $builder->where('requestee_id', '!=', null)->where('status', 'pending');
        } else {
            return $builder;
        }
    }
}