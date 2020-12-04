<?php

namespace App\Http\Resources\Game;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GameEventResource extends GameResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $response = parent::toArray($request);

        $response['type'] = 'event.game.updated';

        unset($response['relationships']);
        unset($response['links']);
//        $response['attributes'] = [
//            'name' => $response['attributes']['name'],
//            'active' => null,
//            'count' => null,
//            'created_at' => $response['attributes']['created_at'],
//            'updated_at' => $response['attributes']['updated_at'],
//        ];

        return $response;
    }
}
