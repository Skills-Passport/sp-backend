<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestFeedbackRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'skill_id' => 'required|exists:skills,id',
            'group_id' => 'nullable|exists:groups,id',
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string',
        ];
    }
}
