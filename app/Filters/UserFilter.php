<?php

namespace App\Filters;

class UserFilter extends AbstractFilter
{
    protected $filters = [
        'search' => SearchFilter::class,
    ];
}