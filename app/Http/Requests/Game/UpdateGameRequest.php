<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'player_count'           => 'integer|between:1,5',
            'correct_points'         => 'integer|min:1|max:1000',
            'points_if_wrong_answer' => 'boolean',
            'wrong_points'           => 'integer|min:1|max:1000',
            'available_joker'        => 'array',
        ];
    }
}
