<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateGroupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->hasPermissionTo('create groups');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'nullable|uuid|exists:groups,id',
            'name' => 'required|string',
            'desc' => 'required|string',
            'skills' => 'nullable|array',
            'skills.id' => 'uuid|exists:skills,id',
            'teachers' => 'required|array',
            'teachers.id' => 'uuid|exists:users,id',
            'students' => 'nullable|array',
            'students.id' => 'uuid|exists:users,id',
        ];
    }

    public function passedValidation()
    {
        $this->merge([
            'teachers' => collect($this->teachers)->map(function ($teacher) {
                return ['user_id' => $teacher, 'role' => 'teacher'];
            })->toArray(),
        ]);
        if (!$this->has('students')) {
            $this->merge([
                'students' => [],
            ]);
        }
    }
}
