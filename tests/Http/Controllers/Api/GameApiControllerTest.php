<?php

namespace Tests\Http\Controllers\Api;

use App\Events\Game\GameUpdatedEvent;
use App\Http\Resources\Game\GameResource;
use App\Models\Game;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class GameApiControllerTest extends TestCase
{
    use ApiControllerTrait;

    /**
     * @var string
     */
    private const STORE_ROUTE   = 'api.v1.game.store';
    private const SHOW_ROUTE    = 'api.v1.game.show';
    private const EXIST_ROUTE   = 'api.v1.game.exists';
    private const UPDATE_ROUTE  = 'api.v1.game.update';
    private const DESTROY_ROUTE = 'api.v1.game.destroy';

    /** @test */
    public function test_game_api_controller_can_store_new_game(): void
    {
        self::assertSame(0, Game::all()->count());

        $response = $this->actingAsUser()
            ->json(
                'POST', route(self::STORE_ROUTE), ['username' => $this->user->username]
            )->assertStatus(200);

        self::assertSame(1, Game::all()->count());

        $game = Game::first();

        self::assertSame([
            'data' => (new GameResource($game))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_game_api_controller_can_return_running_game(): void
    {
        self::assertSame(0, Game::all()->count());
        $this->createGame();
        self::assertSame(1, Game::all()->count());

        $response = $this->actingAsUser()
            ->json(
                'POST', route(self::STORE_ROUTE), ['username' => $this->user->username]
            )->assertStatus(200);

        $game = Game::first();
        $resource = (new GameResource($game))->toArray(new Request());
        $resource['attributes']['is_gamemaster'] = true;

        self::assertSame([
            'data' => $resource
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_game_api_controller_can_show(): void
    {
        $user = User::factory()->create();
        $game = Game::factory()->state([
            'user_id' => $user->id
        ])->create();

        $response = $this->actingAsUser()
            ->json('GET', route(self::SHOW_ROUTE, [
                'gameId' => $game->id
            ]))
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true);

        $game = Game::first();

        self::assertFalse($response['data']['attributes']['is_gamemaster']);
        self::assertSame([
            'data' => (new GameResource($game))->toArray(new Request())
        ], $response);
    }

    /** @test */
    public function test_game_api_controller_can_show_if_gamemaster(): void
    {
        $game = $this->createGame()[0];

        $response = $this->actingAsUser()
            ->json('GET', route(self::SHOW_ROUTE, [
                'gameId' => $game->id
            ]))
            ->assertStatus(200);

        $response = json_decode($response->getContent(), true);
        $game = Game::first();
        $resource = (new GameResource($game))->toArray(new Request());
        $resource['attributes']['is_gamemaster'] = true;

        self::assertTrue($response['data']['attributes']['is_gamemaster']);
        self::assertSame([
            'data' => $resource
        ], $response);
    }

    /** @test */
    public function test_game_api_controller_can_tell_if_exists(): void
    {
        $user = User::factory()->create();
        $game = Game::factory()->state([
            'user_id' => $user->id
        ])->create();

        $response = $this->actingAsUser()
            ->json('GET', route(self::EXIST_ROUTE, [
                'gameId' => $game->id
            ]))
            ->assertStatus(200);

        self::assertSame([
            'success' => true,
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_game_api_controller_can_update(): void
    {
        $game = $this->createGame()[0];

        $payload = [
            'non_existing_field' => 1337,
            'player_count' => 1,
            'correct_points' => 1000,
            'points_if_wrong_answer' => true,
            'wrong_points' => 1000,
        ];

        $this->expectsEvents(GameUpdatedEvent::class);

        $response = $this->actingAsUser()
            ->json('PATCH', route(self::UPDATE_ROUTE, [
                'gameId' => $game->id
            ]), $payload)
            ->assertStatus(200);

        $game = Game::first();

        self::assertSame(1,    (int)$game->player_count);
        self::assertSame(1000, (int)$game->correct_points);
        self::assertSame(true, (bool)$game->points_if_wrong_answer);
        self::assertSame(1000, (int)$game->wrong_points);
        self::assertSame([
            'data' => (new GameResource($game))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_game_api_controller_can_update_joker(): void
    {
        $game = $this->createGame()[0];

        $payload = [
            ['id' => 1, 'count' => 2, 'active' => true]
        ];

        $this->expectsEvents(GameUpdatedEvent::class);

        $response = $this->actingAsUser()
            ->json('PATCH', route(self::UPDATE_ROUTE, [
                'gameId' => $game->id
            ]), $payload)
            ->assertStatus(200);

        $game = Game::first();

        self::assertSame([
            'data' => (new GameResource($game))->toArray(new Request())
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_game_api_controller_can_destroy(): void
    {
        $game = $this->createGame()[0];

        $response = $this->actingAsUser()
            ->json('DELETE', route(self::DESTROY_ROUTE, [
                'gameId' => $game->id
            ]))
            ->assertStatus(200);

        self::assertSame(0, Game::all()->count());
        self::assertSame(0, Question::all()->count());
        self::assertSame(0, User::all()->count());
        self::assertSame([
            'message' => [
                'status' => 200,
                'text' => 'Entry has been successfully deleted!'
            ]
        ], json_decode($response->getContent(), true));
    }
}
