<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class AboveCurrentRating implements Rule
{
    protected $request;

    protected $skill;

    public function __construct(Request $request, $skill)
    {
        $this->request = $request;
        $this->skill = $skill;
    }

    public function passes($attribute, $value)
    {
        $currentRating = $this->request->user()->skills()->find($this->skill->id)->pivot->last_rating;

        return $value > $currentRating;
    }

    public function message()
    {
        return 'The new rating must be higher than the current rating.';
    }
}
