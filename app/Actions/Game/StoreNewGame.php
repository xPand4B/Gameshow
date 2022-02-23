<?php

namespace App\Actions\Game;

use App\Actions\Joker\GetAvailableJoker;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsAction;

class StoreNewGame
{
    use AsAction;

    public function handle(): GameResource
    {
        $userId = Auth::user()->id;

        $game = Game::firstOrCreate([
            'user_id' => $userId,
            'finished' => false
        ], [
            'user_id' => $userId,
            'available_joker' => GetAvailableJoker::run(),
        ]);

        $shouldBeGamemaster = $game->wasRecentlyCreated;

        return new GameResource($game->fresh(), $shouldBeGamemaster);
    }
}
