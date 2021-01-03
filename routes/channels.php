<?php

use App\Models\Game;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

/*
|--------------------------------------------------------------------------
| Game Channel
|--------------------------------------------------------------------------
*/
Broadcast::channel('Game.{id}.Settings', function() {
    return true;
});

Broadcast::channel('Game.{gameId}.Lobby', function ($user, $gameId) {
    $game = Game::findOrFail($gameId);

    $isGamemaster = false;

    if ($game->user_id === $user->id) {
        $isGamemaster = true;
    }

    return [
        'playerName' => $user->username,
        'is_gamemaster' => $isGamemaster
    ];
});

Broadcast::channel('Game.{gameId}.Chat', function ($user, $gameId) {
    return [
        'playerName' => $user->username,
    ];
});
