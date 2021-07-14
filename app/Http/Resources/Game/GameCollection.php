<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameCollection extends ResourceCollection
{
    public function toArray($request): array
    {
        return [
            'attributes' => GameResource::collection($this)
        ];
    }
}
