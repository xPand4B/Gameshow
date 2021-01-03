<?php

namespace App\Http\Resources\Game;

use App\Models\Joker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Crypt;

class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'type' => 'game',
            'id' => $this->id,
            'attributes' => [
                'is_gamemaster' => false,
                'player_count' => (int) $this->player_count,
                'correct_points' => (int) $this->correct_points,
                'points_if_wrong_answer' => (bool) $this->points_if_wrong_answer,
                'wrong_points' => (int) $this->wrong_points,
                'available_joker' => $this->formatAvailableJoker($request),
                'finished' => (bool) $this->finished,
                'created_at' => (string) $this->created_at,
                'updated_at' => (string) $this->updated_at
            ],
            'links' => [
                'self' => route('api.v1.game.show', ['gameId' => $this->id]),
            ],
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    private function formatAvailableJoker(Request $request): array
    {
        $activeJoker = [];

        foreach ($this->available_joker as $item) {
            $id = $item['id'];
            $count = $item['count'];
            $active = $item['active'];

            $joker = Joker::findOrFail($id);

            $gameJokerResource = (new GameJokerResource($joker))->toArray($request);
            $gameJokerResource['attributes']['count'] = $count;
            $gameJokerResource['attributes']['active'] = $active;

            $activeJoker[] = $gameJokerResource;
        }

        return $activeJoker;
    }
}
