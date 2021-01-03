<?php

namespace Tests\Http\Resources\Game;

use App\Models\Game;
use Tests\TestCase;

class GameCollectionTest extends TestCase
{
    use GameResourceTrait;

    /** @test */
    public function test_game_resource_collection_has_correct_format(): void
    {
        $this->createGame(4);
        self::assertSame(4, Game::all()->count());

        $resource = $this->getGameCollection();

        self::assertIsArray($resource);
        self::assertArrayHasKey('attributes', $resource);
        self::assertCount(4, $resource['attributes']);
    }
}
