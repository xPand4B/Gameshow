<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'attributes' => QuestionResource::collection($this)
        ];
    }
}
