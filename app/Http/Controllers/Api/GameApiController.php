<?php

namespace App\Http\Controllers\Api;

use App\Events\Game\GameUpdatedEvent;
use App\Helper\AuthHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Game\CreateGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Http\Resources\Game\GameCollection;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\Joker;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\JsonResponse;

class GameApiController extends Controller
{
    /** @var string  */
    public const SESSION_KEY_GAMEMASTER_USERNAME = 'gamemaster.name';

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return GameCollection
     */
    public function index(Request $request): GameCollection
    {
        $games = Game::pagyinate(15);

        return new GameCollection($games);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateGameRequest $request
     * @return GameResource|JsonResponse
     */
    public function store(CreateGameRequest $request)
    {
        $request->validated();

        AuthHelper::login(
            $request->get('username')
        );

        // Check if GM has a game running
        $runningGames = Game::where([
            ['gamemaster', '=', auth()->user()->username],
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
            'gamemaster' => auth()->user()->username,
            'available_joker'    => $this->getAllAvailableJoker(),
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

//        broadcast(new LobbyJoinedEvent($game))->toOthers();

        return response()->json($resource);
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
