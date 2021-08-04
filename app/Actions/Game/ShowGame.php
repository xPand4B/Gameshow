<?php

namespace App\Actions\Game;

use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class ShowGame
{
    use AsAction;

    public function handle(string $gameId): GameResource
    {
        /** @var Game $game */
        $game = Game::findOrFail($gameId);

        $shouldBeGameMaster = Auth::user()->id === $game->user_id;

        return new GameResource($game, $shouldBeGameMaster);
    }
}
