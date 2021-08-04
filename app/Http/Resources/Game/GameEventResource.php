<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameEventResource extends GameResource
{
    public function toArray($request): array
    {
        $response = parent::toArray($request);

        unset($response['links']);
        $response['type'] = 'event.game.updated';

        return $response;
    }
}
