<?php

namespace App\Actions\Game;

use App\Models\Game;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateGame
{
    use AsAction;

    private Game $game;

    public function handle(Request $request, string $gameId): Game
    {
        $this->game = Game::findOrFail($gameId);
        $params = $request->all();

        // Get all attributes and update automatically
        $this->updateNormalAttributes($params);
        // Check if param is Joker
        $this->updateIfParamsContainJoker($params);

        $this->game->save();

        return $this->game;
    }

    protected function updateNormalAttributes(array $params): void
    {
        foreach ($params as $attribute => $value) {
            if (!array_key_exists($attribute, $this->game->getAttributes())) {
                continue;
            }

            $this->game->{$attribute} = $value;
        }
    }

    protected function updateIfParamsContainJoker(array $params): void
    {
        if (!array_key_exists(0, $params)) {
            return;
        }

        if (array_key_exists('id', $params[0])
         && array_key_exists('count', $params[0])
         && array_key_exists('active', $params[0])
        ) {
            $this->game->available_joker = $params;
        }
    }
}
