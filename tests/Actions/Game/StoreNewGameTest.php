<?php

namespace Tests\Actions\Game;

use App\Actions\Game\StoreNewGame;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @group Actions
 */
class StoreNewGameTest extends TestCase
{
    /** @test */
    public function test_it_can_store_new_game_as_gamemaster(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        self::assertCount(1, User::all());

        Auth::login($user);
        self::assertTrue(Auth::check());

        self::assertCount(0, Game::all());
        $actual = StoreNewGame::run();
        self::assertCount(1, Game::all());

        self::assertEquals(new GameResource(Game::first(), true), $actual);
    }

    /** @test */
    public function test_it_can_store_new_game_as_player(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        self::assertCount(1, User::all());

        Auth::login($user);
        self::assertTrue(Auth::check());

        Game::factory()->create(['user_id' => $user->id]);

        self::assertCount(1, Game::all());
        $actual = StoreNewGame::run();
        self::assertCount(1, Game::all());

        self::assertEquals(new GameResource(Game::first()), $actual);
    }
}
