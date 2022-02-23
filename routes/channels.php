<?php

use App\Models\Game;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Settings
|--------------------------------------------------------------------------
*/
Broadcast::channel('Game.{id}.Settings', function() {
    return true;
});

/*
|--------------------------------------------------------------------------
| Lobby
|--------------------------------------------------------------------------
*/
Broadcast::channel('Game.{gameId}.Lobby', function ($user, $gameId) {
    /** @var Game $game */
    $game = Game::findOrFail($gameId);

    $isGamemaster = false;

    if ($game->user_id === $user->id) {
        $isGamemaster = true;
    }

    return [
        'id' => $user->id,
        'playerName' => $user->username,
        'is_gamemaster' => $isGamemaster
    ];
});

/*
|--------------------------------------------------------------------------
| Chat
|--------------------------------------------------------------------------
*/
Broadcast::channel('Game.{gameId}.Chat', function ($user, $gameId) {
    return [
        'playerName' => $user->username,
    ];
});
