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
            'id' => 'nullable|uuid',
            'name' => 'required|string',
            'desc' => 'required|string',
            'skills' => 'nullable|array',
            'skills.id' => 'uuid|exists:skills,id',
            'teachers' => 'nullable|array',
            'teachers.id' => 'uuid|exists:users,id',
            'students' => 'nullable|array',
            'students.id' => 'uuid|exists:users,id',
        ];
    }

    public function passedValidation()
    {
        if (!$this->has('id')) {
            $this->merge([
                'created_by' => auth()->id(),
            ]);
        }
        if ($this->has('teachers')) {
            $this->merge([
                'teachers' => collect($this->teachers)->map(function ($teacher) {
                    return ['user_id' => $teacher, 'role' => 'teacher'];
                })->toArray(),
            ]);
        }
        else {
            $this->merge([
                'teachers' => [],
            ]);
        }
        if (!$this->has('students')) {
            $this->merge([
                'students' => [],
            ]);
        }

        $this->merge([
            'teachers' => array_merge($this->teachers, [['user_id' => auth()->id(), 'role' => 'teacher']]),
        ]);
    }
}
