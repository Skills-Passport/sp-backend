<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|uuid|exists:profiles,id',
            'title' => 'required|string',
            'desc' => 'required|string',
            'color' => 'required|string',
            'icon' => 'required|string',
            'competencies' => 'nullable|array',
            'competencies.id' => 'uuid|exists:competencies,id',
        ];
    }

    public function passedValidation()
    {
        if (! $this->has('competencies')) {
            $this->merge([
                'competencies' => [],
            ]);
        }
    }
}
