<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'content' => 'required|string|min:10',
            'skill_id' => 'required|exists:skills,id',
            'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string',
        ];
    }
}