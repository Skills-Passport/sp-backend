<?php

namespace App\Traits;

trait PopulatesIfEmpty
{
    /**
     * Boot the trait to ensure the model is not empty.
     */
    protected static function boot()
    {
        parent::boot();
        static::populatesIfEmpty();
    }

    /**
     * Ensure the model has data by using its factory if the table is empty.
     *
     * @param int $count Number of rows to create if empty.
     */
    public static function populatesIfEmpty($count = 10)
    {
        if (static::count() === 0 && method_exists(static::class, 'factory')) {
            static::factory()->count($count)->create();
        }
    }
}
