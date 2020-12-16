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

Broadcast::channel('Game.{id}.Lobby', function ($user, $id) {
    $game = Game::findOrFail($id);

    $isGamemaster = false;

    if ($game->gamemaster === $user->username) {
        $isGamemaster = true;
    }

    return [
        'playerName' => $user->username,
        'is_gamemaster' => $isGamemaster
    ];
});

Broadcast::channel('Game.{id}.Chat', function ($user, $id) {
    return [
        'playerName' => $user->username,
    ];
});
