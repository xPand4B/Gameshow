<?php

namespace App\Http\Controllers\Api;

use App\Events\Lobby\LobbyJoinedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Lobby\JoinLobbyRequest;
use App\Models\Game;

class LobbyApiController extends Controller
{
    public function join(JoinLobbyRequest $request, Game $game)
    {
        $request->validated();

        // TODO: Broadcast joining event

        // Get joining user
        $playerName = $request->get('playerName');

        // Broadcast joined event
        broadcast(new LobbyJoinedEvent($game, $playerName))->toOthers();

        return response()->json([
            'success' => true
        ]);
    }
}
