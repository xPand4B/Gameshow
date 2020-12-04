<?php

namespace Tests\Helper;

use App\Helper\MessageResponse;
use Tests\TestCase;

class MessageResponseTest extends TestCase
{
    /** @test */
    public function test_message_response_returns_json(): void
    {
        $response = MessageResponse::json(
            'Sample Message', 201
        );
        $response = json_decode($response->getContent(), true);

        self::assertIsArray($response);
        self::assertSame([
            'message' => [
                'status' => 201,
                'text' => 'Sample Message'
            ]
        ], $response);
    }
}
