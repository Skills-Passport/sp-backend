<?php

namespace App\Modules\Skills\Requests\Teachers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'skill_id' => 'required|exists:skills,id',
            'name' => 'required|string',
            'desc' => 'required|string',
            'competency_id' => 'required|exists:competencies,id',
        ];
    }
}