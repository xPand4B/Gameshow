<?php

namespace App\Actions\Game;

use App\Models\Game;
use Lorisleiva\Actions\Concerns\AsAction;

class DestroyGame
{
    use AsAction;

    public function handle(string $gameId): void
    {
        /** @var Game $game */
        $game = Game::findOrFail($gameId);

        $game->user->delete();
        $game->delete();
    }
}
