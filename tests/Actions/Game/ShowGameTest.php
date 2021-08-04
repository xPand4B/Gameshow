<?php

namespace Tests\Actions\Game;

use App\Actions\Game\ShowGame;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @group Actions
 */
class ShowGameTest extends TestCase
{
    /** @test */
    public function test_it_can_show_game2(): void
    {
        /** @var Game $game */
        $game = Game::factory()->create();
        self::assertCount(1, Game::all());

        /** @var User $user */
        $user = User::factory()->create();
        self::assertCount(2, User::all());

        Auth::login($user);
        self::assertTrue(Auth::check());

        $actual = ShowGame::run($game->id);
        self::assertEquals(new GameResource($game->fresh()), $actual);
    }

    /** @test */
    public function test_it_can_show_game_as_gamemaster(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        self::assertCount(1, User::all());

        /** @var Game $game */
        $game = Game::factory()->create(['user_id' => $user->id]);
        self::assertCount(1, Game::all());

        Auth::login($user);
        self::assertTrue(Auth::check());

        $actual = ShowGame::run($game->id);
        self::assertEquals(new GameResource($game->fresh(), true), $actual);
    }

    /** @test */
    public function test_it_can_throw_error_with_invalid_game_id(): void
    {
        self::expectException(ModelNotFoundException::class);
        ShowGame::run('some-weird-id');
    }
}
