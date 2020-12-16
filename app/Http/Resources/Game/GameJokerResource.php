<?php

namespace App\Http\Resources\Game;

use App\Http\Resources\Joker\JokerResource;
use Illuminate\Http\Request;

class GameJokerResource extends JokerResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        $response = parent::toArray($request);

        unset($response['relationships']);
        $response['attributes'] = [
            'name' => $response['attributes']['name'],
            'active' => null,
            'count' => null,
            'created_at' => $response['attributes']['created_at'],
            'updated_at' => $response['attributes']['updated_at'],
        ];

        return $response;
    }
}
