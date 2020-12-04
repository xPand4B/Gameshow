<?php declare(strict_types=1);

namespace Tests\Http\Resources\Game;

use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\User;
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

    private function createGameResource(int $count = 1): void
    {
        Game::factory()->count($count)->create([
            'user_id' => $this->user->id
        ]);
    }

    private function getJokerResource(): array
    {
        $request = new Request();
        $game = Game::first();

        return (new GameResource($game))->toArray($request);
    }
}
