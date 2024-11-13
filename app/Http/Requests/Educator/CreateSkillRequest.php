<?php

namespace App\Modules\Skills\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class CreateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'desc' => 'required|string',
            'competency_id' => 'required|exists:competencies,id',
        ];
    }
}