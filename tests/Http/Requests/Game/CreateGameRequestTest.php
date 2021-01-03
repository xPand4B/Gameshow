<?php

namespace Tests\Http\Requests\Game;

use App\Http\Requests\Game\CreateGameRequest;
use Tests\TestCase;

class CreateGameRequestTest extends TestCase
{
    /**
     * @return CreateGameRequest
     */
    private function getGameRequest(): CreateGameRequest
    {
        return new CreateGameRequest();
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
            'username' => 'required|bail|string|max:20',
        ], $this->getGameRequest()->rules());
    }

}
