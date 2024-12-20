<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRatingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'between:1,4'],
            'feedback' => ['required', 'string', 'min:10'],
        ];
    }
}
