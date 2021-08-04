<?php

namespace Tests\Actions\Game;

use App\Actions\Game\UpdateGame;
use App\Models\Game;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Tests\TestCase;

/**
 * @group Actions
 */
class UpdateGameTest extends TestCase
{
    /** @test */
    public function test_it_can_update_normal_game_attributes(): void
    {
        /** @var Game $game */
        $game = Game::factory()->create();
        self::assertCount(1, Game::all());

        $game = $game->fresh();
        self::assertSame(4, $game->player_count);
        self::assertSame(5, $game->correct_points);
        self::assertSame(true, $game->points_if_wrong_answer);
        self::assertSame(1, $game->wrong_points);

        $request = new Request([
            'something-wrong' => 'blub',
            'player_count' => 1,
            'correct_points' => 1337,
            'points_if_wrong_answer' => false,
            'wrong_points' => 2337
        ]);

        /** @var Game $game */
        $game = UpdateGame::run($request, $game->id);

        self::assertSame(1, $game->player_count);
        self::assertSame(1337, $game->correct_points);
        self::assertSame(false, $game->points_if_wrong_answer);
        self::assertSame(2337, $game->wrong_points);
    }

    /** @test */
    public function test_it_can_update_joker(): void
    {
        /** @var Game $game */
        $game = Game::factory()->create();
        self::assertCount(1, Game::all());

        $game = $game->fresh();
        self::assertCount(4, $game->available_joker);

        $request = new Request([[
            'id' => 1,
            'count' => 1337,
            'active' => true
        ]]);

        /** @var Game $actual */
        $actual = UpdateGame::run($request, $game->id);

        self::assertCount(1, $actual->available_joker);
        self::assertSame([
            ['id' => 1, 'count' => 1337, 'active' => true]
        ], $actual->available_joker);
    }

    /** @test */
    public function test_it_can_check_if_game_exists_before_update(): void
    {
        self::expectException(ModelNotFoundException::class);
        UpdateGame::run(new Request(), 1337);
    }
}
