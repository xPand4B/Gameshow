<?php

namespace App\Http\Controllers\Api;

use App\Events\Game\GameUpdatedEvent;
use App\Helper\MessageResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\Joker;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameApiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGameRequest $request
     * @return GameResource|JsonResponse
     */
    public function store(CreateGameRequest $request)
    {
        $request->validated();

        // Check if GM has a game running
        $runningGames = Game::where([
            ['user_id', '=', Auth::user()->id],
            ['finished', '=', false]
        ])->get();

        if ($runningGames->count() !== 1) {
            // Create game
            $game = Game::create([
                'user_id'         => Auth::user()->id,
                'available_joker' => $this->getAllAvailableJoker(),
            ]);
            $game = Game::where(['id' => $game->id])->first();

            return new GameResource($game);
        }

        $resource = [
            'data' => (new GameResource($runningGames[0]))->toArray($request)
        ];
        $resource['data']['attributes']['is_gamemaster'] = true;

        return response()->json($resource);
    }

    /**
     * @param Request $request
     * @param string $gameId
     * @return JsonResponse
     */
    public function show(Request $request, string $gameId): JsonResponse
    {
        // Get GameResource
        $game = Game::findOrFail($gameId);
        $resource = [
            'data' => (new GameResource($game))->toArray($request)
        ];

        // Check if there is something inside the session
        if (Auth::user()->id === (int)$game->user_id) {
            $resource['data']['attributes']['is_gamemaster'] = true;
        }

        return response()->json($resource);
    }

    /**
     * @param Request $request
     * @param string $gameId
     * @return JsonResponse
     */
    public function exists(Request $request, string $gameId): JsonResponse
    {
        $response = [
            'success' => true,
        ];

        $game = Game::findOrFail($gameId);

        if (Auth::check()) {
            $isGamemaster = (int)$game->user_id === Auth::user()->id;

            if ($isGamemaster) {
                $response['is_gamemaster'] = true;
            }
        }

        return response()->json($response);
    }

    /**
     * @param UpdateGameRequest $request
     * @param string $gameId
     * @return GameResource
     */
    public function update(UpdateGameRequest $request, string $gameId): GameResource
    {
        $request->validated();

        $params = $request->all();
        $game = Game::findOrFail($gameId);

        foreach ($params as $attribute => $value) {
            if (!array_key_exists($attribute, $game->getAttributes())) {
                continue;
            }

            $game->update([
                $attribute => $value
            ]);
        }

        if (array_key_exists(0, $params)) {
            if (array_key_exists('id', $params[0]) && array_key_exists('count', $params[0]) && array_key_exists('active', $params[0])) {
                $game->update([
                    'available_joker' => $params
                ]);
            }
        }

        $game->save();

        broadcast(new GameUpdatedEvent($game))->toOthers();

        return new GameResource($game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param string $gameId
     * @return JsonResponse
     */
    public function destroy(Request $request, string $gameId): JsonResponse
    {
        $game = Game::findOrFail($gameId);
        $game->delete();

        $game->user->delete();

        return MessageResponse::json('Entry has been successfully deleted!');
    }

    /**
     * @return array
     */
    private function getAllAvailableJoker(): array
    {
        $jokers = Joker::all();
        $availableJoker = [];

        foreach ($jokers as $joker) {
            $availableJoker[] = [
                'id' => $joker->id,
                'active' => false,
                'count' => 1,
            ];
        }

        return $availableJoker;
    }
}
