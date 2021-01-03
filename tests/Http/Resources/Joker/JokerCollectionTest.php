<?php

namespace Tests\Http\Resources\Joker;


use App\Models\Joker;
use Tests\TestCase;

class JokerCollectionTest extends TestCase
{
    use JokerResourceTrait;

    /** @test */
    public function test_joker_resource_collection_has_correct_format(): void
    {
        self::assertSame(4, Joker::all()->count());

        $resource = $this->getJokerCollection();

        self::assertIsArray($resource);
        self::assertArrayHasKey('attributes', $resource);
    }
}
