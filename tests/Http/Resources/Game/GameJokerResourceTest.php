<?php

namespace Tests\Http\Resources\Game;

use App\Helper\MessageResponse;
use App\Models\Game;
use Tests\TestCase;

/**
 * @group Resources
 */
class GameJokerResourceTest extends TestCase
{
    use GameResourceTrait;

    /** @test */
    public function test_game_resource_has_correct_format(): void
    {
        $this->createGame(4);
        self::assertSame(4, Game::all()->count());

        $resource = $this->getGameResource();

        self::assertIsArray($resource);
        self::assertArrayHasKey('created_at', $resource['attributes']);
        self::assertArrayHasKey('updated_at', $resource['attributes']);
        self::assertCount(4, $resource['attributes']['available_joker']);

        $resource['attributes']['available_joker'] = null;
        $resource['attributes']['created_at'] = null;
        $resource['attributes']['updated_at'] = null;

        self::assertSame([
            'is_gamemaster' => false,
            'player_count' => 4,
            'correct_points' => 5,
            'points_if_wrong_answer' => true,
            'wrong_points' => 1,
            'available_joker' => null,
            'finished' => false,
            'created_at' => null,
            'updated_at' => null,
        ], $resource['attributes']);
    }
}
