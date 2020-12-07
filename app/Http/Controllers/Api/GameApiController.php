<?php

namespace App\Http\Controllers\Api;

use App\Events\Game\GameUpdatedEvent;
use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\Joker;
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
            ['gamemaster', '=', Auth::user()->username],
            ['finished', '=', false]
        ])->get();

        if ($runningGames->count() === 1) {
            $resource = [
                'data' => (new GameResource($runningGames[0]))->toArray($request)
            ];
            $resource['data']['attributes']['is_gamemaster'] = true;

            return response()->json($resource);
        }

        // Create game
        $game = Game::create([
            'gamemaster'      => Auth::user()->username,
            'available_joker' => $this->getAllAvailableJoker(),
        ]);

        return new GameResource($game);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function show(Request $request, $id): JsonResponse
    {
        // Get GameResource
        $game = Game::findOrFail($id);
        $resource = [
            'data' => (new GameResource($game))->toArray($request)
        ];

        // Check if there is something inside the session
        if (auth()->user()) {
            if (auth()->user()->username === $game->gamemaster) {
                $resource['data']['attributes']['is_gamemaster'] = true;
            }
        }

        return response()->json($resource);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function exists(Request $request, $id): JsonResponse
    {
        $response = [
            'success' => true,
        ];

        $game = Game::findOrFail($id);

        if (Auth::check()) {
            $isGamemaster = $game->gamemaster === Auth::user()->username;

            if ($isGamemaster) {
                $response['is_gamemaster'] = true;
            }
        }

        return response()->json($response);
    }

    /**
     * @param UpdateGameRequest $request
     * @param $id
     * @return GameResource
     */
    public function update(UpdateGameRequest $request, $id)
    {
        $request->validated();

        $params = $request->all();
        $game = Game::findOrFail($id);

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
     * @param $id
     * @return JsonResponse
     */
    public function destroy(Request $request, $id): JsonResponse
    {
        $game = Game::findOrFail($id);
        $game->delete();

        return response()->json([
           'data' => [

           ]
        ]);
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
                'count' => 1
            ];
        }

        return $availableJoker;
    }
}
