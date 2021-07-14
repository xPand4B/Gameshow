<?php

namespace Tests\Http\Resources\Game;

use App\Http\Resources\Game\GameCollection;
use App\Http\Resources\Game\GameEventResource;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait GameResourceTrait
{
    /**
     * @var User
     */
    private $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * @param int $count
     * @return Collection|Model|mixed
     */
    private function createGame(int $count = 1)
    {
        return Game::factory()->count($count)->state([
            'user_id' => $this->user->id
        ])->create();
    }

    private function getGameResource(): array
    {
        $request = new Request();
        $game = Game::first();

        return (new GameResource($game))->toArray($request);
    }

    private function getGameCollection(): array
    {
        $request = new Request();
        $game = Game::all();

        return (new GameCollection($game))->toArray($request);
    }

    private function getGameEventResource(): array
    {
        $request = new Request();
        $game = Game::first();

        return (new GameEventResource($game))->toArray($request);
    }
}
