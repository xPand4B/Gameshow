<?php

namespace Tests\Http\Controllers\Api;

use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @group Controllers
 * @group Api
 */
class AuthApiControllerTest extends TestCase
{
    use ApiControllerTrait;

    private const LOGIN_ROUTE = 'api.v1.auth.login';
    private const ME_ROUTE = 'api.v1.auth.me';
    private const GAME_STORE_ROUTE = 'api.v1.game.store';

    /** @test */
    public function test_auth_api_controller_can_login(): void
    {
        self::assertFalse(Auth::check());

        $response = $this->json(
            'POST', route(self::LOGIN_ROUTE), ['username' => $this->user->username]
        )->assertStatus(200);

        self::assertTrue(Auth::check());
        self::assertSame([
            'success' => true,
            'id' => 2,
            'playerName' => $this->user->username,
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_auth_api_controller_can_get_me(): void
    {
        $response = $this->actingAsUser()
            ->json('GET', route(self::ME_ROUTE))
            ->assertStatus(200);

        self::assertSame([
            'success' => true,
            'id' => $this->user->id,
            'playerName' => $this->user->username,
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_can_create_game_after_auth(): void
    {
        $this->withoutExceptionHandling();

        self::assertFalse(Auth::check());

        $response = $this->json(
            'POST', route(self::LOGIN_ROUTE), ['username' => $this->user->username]
        )->assertStatus(200);

        self::assertTrue(Auth::check());
        self::assertSame([
            'success' => true,
            'id' => 2,
            'playerName' => $this->user->username,
        ], json_decode($response->getContent(), true));

        self::assertSame(0, Game::all()->count());
        $response = $this->json(
            'POST', route(self::GAME_STORE_ROUTE), ['username' => $this->user->username]
        )->assertStatus(200);
        self::assertSame(1, Game::all()->count());

        $game = Game::first();

        self::assertSame([
            'data' => (new GameResource($game, true))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }
}
