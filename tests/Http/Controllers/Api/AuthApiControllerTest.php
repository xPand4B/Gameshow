<?php

namespace Tests\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthApiControllerTest extends TestCase
{
    use ApiControllerTrait;

    private const LOGIN_ROUTE = 'api.v1.auth.login';
    private const ME_ROUTE    = 'api.v1.auth.me';

    /** @test */
    public function test_auth_api_controller_can_login(): void
    {
        self::assertFalse(Auth::check());

        $response = $this->json(
            'POST', route(self::LOGIN_ROUTE), ['username' => $this->user->username]
        )->assertStatus(200);

        self::assertTrue(Auth::check());
        self::assertSame([
            'success' => true,
            'id' => 2,
            'playerName' => $this->user->username,
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_auth_api_controller_can_get_me(): void
    {
        $response = $this->actingAsUser()
            ->json('GET', route(self::ME_ROUTE))
            ->assertStatus(200);

        self::assertSame([
            'success' => true,
            'id' => $this->user->id,
            'playerName' => $this->user->username,
        ], json_decode($response->getContent(), true));
    }
}
