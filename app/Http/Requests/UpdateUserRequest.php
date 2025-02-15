<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['email', 'unique:users,email,'.$this->user->id],
            'first_name' => ['string'],
            'last_name' => ['string'],
            'personal_coach' => ['exists:users,id'],
            'job_title' => ['string'],
            'field' => ['string'],
            'image' => ['image'],
            'address' => ['string'],
            'role_id' => ['exists:roles,id'],
        ];
    }
}
