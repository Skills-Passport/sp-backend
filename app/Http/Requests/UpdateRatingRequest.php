<?php

namespace App\Http\Requests;

use App\Rules\AboveCurrentRating;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'between:1,4', new AboveCurrentRating($this, $this->route('skill'))],
            'feedback' => ['required', 'string', 'min:10'],
        ];
    }
}