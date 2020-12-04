<?php

namespace Tests\Http\Resources\Joker;

use App\Http\Resources\Joker\JokerResource;
use App\Models\Joker;
use Illuminate\Http\Request;
use Tests\TestCase;

class JokerResourceTest extends TestCase
{
    private function getJokerResource(): array
    {
        $request = new Request();
        $joker = Joker::first();

        return (new JokerResource($joker))->toArray($request);
    }

    /** @test */
    public function test_joker_resource_has_correct_format(): void
    {
        self::assertSame(4, Joker::all()->count());

        $resource = $this->getJokerResource();

        self::assertIsArray($resource);
        self::assertArrayHasKey('created_at', $resource['attributes']);
        self::assertArrayHasKey('updated_at', $resource['attributes']);

        $resource['attributes']['created_at'] = null;
        $resource['attributes']['updated_at'] = null;

        self::assertSame([
            'type' => 'joker',
            'id' => 1,
            'attributes' => [
                'name' => 'telephone',
                'created_at' => null,
                'updated_at' => null,
            ],
            'relationships' => null,
            'links' => [
                'self' => 'http://gameshow.test:8080/api/v1/joker/1',
                'related' => null
            ]
        ], $resource);
    }
}
