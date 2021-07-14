<?php

namespace Tests\Http\Controllers\Api;

use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait ApiControllerTrait
{
    /**
     * @var User
     */
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        self::assertSame(1, User::all()->count());
    }

    /**
     * @param int $count
     * @return Collection|Model|mixed
     */
    public function createGame(int $count = 1)
    {
        $countBefore = Game::all()->count();

        $game = Game::factory()->count($count)->state([
            'user_id' => $this->user->id
        ])->create();

        $countAfter = Game::all()->count();

        self::assertSame($countAfter, $countBefore + 1);
        self::assertSame($count, Question::all()->count());

        return $game;
    }

    public function actingAsUser(): self
    {
        Auth::logout();
        self::assertFalse(Auth::check());

        $this->actingAs($this->user);
        self::assertTrue(Auth::check());

        return $this;
    }
}
