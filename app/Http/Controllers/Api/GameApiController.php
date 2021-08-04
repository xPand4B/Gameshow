<?php

namespace App\Http\Controllers\Api;

use App\Actions\Game\DestroyGame;
use App\Actions\Game\ShowGame;
use App\Actions\Game\StoreNewGame;
use App\Actions\Game\UpdateGame;
use App\Events\Game\GameUpdatedEvent;
use App\Helper\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameApiController extends Controller
{
    public function store(CreateGameRequest $request)
    {
        $request->validated();

        return StoreNewGame::run();
    }

    public function show(Request $request, string $gameId): GameResource
    {
        return ShowGame::run($gameId);
    }

    public function exists(string $gameId): JsonResponse
    {
        Game::findOrFail($gameId);

        return response()->json([
            'success' => true,
        ]);
    }

    public function update(UpdateGameRequest $request, string $gameId): GameResource
    {
        $game = UpdateGame::run($request, $gameId);

        broadcast(new GameUpdatedEvent($game))->toOthers();

        return new GameResource($game);
    }

    public function destroy(Request $request, string $gameId): JsonResponse
    {
        DestroyGame::run($gameId);

        return MessageResponse::json('Entry has been successfully deleted!');
    }
}
