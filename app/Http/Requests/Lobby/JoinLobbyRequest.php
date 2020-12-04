<?php

namespace App\Http\Requests\Lobby;

use Illuminate\Foundation\Http\FormRequest;

class JoinLobbyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'playerName' => 'required|bail|alpha_num|max:20',
        ];
    }
}
