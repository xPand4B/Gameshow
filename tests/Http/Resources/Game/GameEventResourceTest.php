<?php

namespace Tests\Http\Resources\Game;

use App\Models\Game;
use Tests\TestCase;

/**
 * @group Resources
 */
class GameEventResourceTest extends TestCase
{
    use GameResourceTrait;

    /** @test */
    public function test_game_event_resource_has_correct_format(): void
    {
        $game = $this->createGame()[0];
        self::assertSame(1, Game::all()->count());

        $resource = $this->getGameEventResource();

        self::assertIsArray($resource);

        self::assertArrayHasKey('type', $resource);
        self::assertSame('event.game.updated', $resource['type']);

        self::assertSame($game->id, $resource['id']);

        self::assertArrayNotHasKey('links', $resource);
    }
}
