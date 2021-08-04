<?php

namespace Tests\Actions\Game;

use App\Actions\Game\DestroyGame;
use App\Models\Game;
use App\Models\User;
use Tests\TestCase;

/**
 * @group Actions
 */
class DestroyGameTest extends TestCase
{
    /** @test */
    public function it_can_delete_a_game(): void
    {
        $this->withoutEvents();

        $game = Game::factory()->create();
        self::assertCount(1, User::all());
        self::assertCount(1, Game::all());

        DestroyGame::run($game->id);

        self::assertCount(0, User::all());
        self::assertCount(0, Game::all());
    }
}
