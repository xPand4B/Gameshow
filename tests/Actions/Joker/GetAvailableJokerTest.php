<?php

namespace Tests\Actions\Joker;

use App\Actions\Joker\GetAvailableJoker;
use Tests\TestCase;

/**
 * @group Actions
 */
class GetAvailableJokerTest extends TestCase
{
    /** @test */
    public function test_it_can_get_all_available_joker(): void
    {
        $response = GetAvailableJoker::run();

        self::assertSame([
            ['id' => 1, 'active' => false, 'count' => 1],
            ['id' => 2, 'active' => false, 'count' => 1],
            ['id' => 3, 'active' => false, 'count' => 1],
            ['id' => 4, 'active' => false, 'count' => 1],
        ], $response);
    }
}
