<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class UserFilter extends AbstractFilter
{
    protected $filters = [
        'search' => SearchFilter::class,
    ];
}