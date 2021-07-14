<?php

namespace App\Http\Resources\Joker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class JokerCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'attributes' => JokerResource::collection($this)
        ];
    }
}
