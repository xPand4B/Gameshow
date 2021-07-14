<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'type' => 'question',
            'id' => $this->id,
            'attributes' => [
                'question' => $this->question,
                'answers' => $this->answers,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at,
            ],
        ];
    }
}
