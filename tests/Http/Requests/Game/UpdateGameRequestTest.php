<?php

namespace Tests\Http\Requests\Game;

use App\Http\Requests\Game\UpdateGameRequest;
use Tests\TestCase;

/**
 * @group Requests
 */
class UpdateGameRequestTest extends TestCase
{
    private function getGameRequest(): UpdateGameRequest
    {
        return new UpdateGameRequest();
    }

    /** @test */
    public function test_game_request_authorization(): void
    {
        self::assertTrue($this->getGameRequest()->authorize());
    }

    /** @test */
    public function test_game_request_rules(): void
    {
        self::assertSame([
            'player_count'           => 'integer|between:1,5',
            'correct_points'         => 'integer|min:1|max:1000',
            'points_if_wrong_answer' => 'boolean',
            'wrong_points'           => 'integer|min:1|max:1000',
            'available_joker'        => 'array',
        ], $this->getGameRequest()->rules());
    }
}
