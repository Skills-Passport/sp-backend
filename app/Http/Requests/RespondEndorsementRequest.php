<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RespondEndorsementRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string'],
            'request_id' => [
                'required',
                Rule::exists('endorsement_requests', 'id')->where(function ($query) {
                    $query->whereIn('status', ['filled', 'pending']);
                }),
            ],
            'content' => ['required', 'string'],
            'rating' => ['required', 'numeric', 'min:1', 'max:4'],
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'created_by' => auth()->id(),
            'skill_id' => $this->endorsementRequest->skill_id,
            'user_id' => $this->endorsementRequest->requester_id,
        ]);
    }
}
