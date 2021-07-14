<?php

namespace App\Http\Requests\Question;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'bail|required|alpha_num',
            'value'     => 'bail|required',
            'answerId'  => 'bail|numeric',
        ];
    }
}
