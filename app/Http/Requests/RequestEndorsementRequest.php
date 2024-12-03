<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestEndorsementRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'skill' => 'required|exists:skills,id',
            'requestee' => 'required_without:requestee_email|exists:users,id',
            'requestee_email' => 'required_without:requestee|email',
        ];
    }
}
