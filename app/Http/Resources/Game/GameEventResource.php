<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameEventResource extends GameResource
{
    public function toArray($request): array
    {
        $response = parent::toArray($request);

        $response['type'] = 'event.game.updated';

        unset($response['links']);

        return $response;
    }
}
