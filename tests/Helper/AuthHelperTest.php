<?php

namespace Tests\Helper;

use App\Actions\Auth\LogoutUser;
use App\Helper\AuthHelper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @group Helper
 */
class AuthHelperTest extends TestCase
{
    private const SAMPLE_USERNAME = 'xPand';

    /** @test */
    public function test_auth_helper_can_create_and_login_user(): void
    {
        self::assertSame(0, User::all()->count());
        self::assertFalse(Auth::check());

        $response = AuthHelper::login(new Request(), self::SAMPLE_USERNAME);

        self::assertSame(1, User::all()->count());
        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USERNAME, Auth::user()->username);
        self::assertSame(User::first()->auth_token, Auth::user()->auth_token);

        self::assertSame([
            'success' => true,
            'id' => 1,
            'playerName' => self::SAMPLE_USERNAME
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_auth_helper_can_login_existing_user(): void
    {
        self::assertSame(0, User::all()->count());
        self::assertFalse(Auth::check());

        $token = Str::random(24);
        User::factory()->count(9)->create();
        User::factory()->create([
            'username' => self::SAMPLE_USERNAME,
            'auth_token' => $token,
        ]);
        self::assertSame(10, User::all()->count());

        $request = new Request(
            [], [], [], [AuthHelper::AUTH_TOKEN_NAME => $token]
        );

        $response = AuthHelper::login($request, self::SAMPLE_USERNAME);
        self::assertSame(10, User::all()->count());

        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USERNAME, Auth::user()->username);
        self::assertSame($token, Auth::user()->auth_token);

        self::assertSame([
            'success' => true,
            'id' => 10,
            'playerName' => self::SAMPLE_USERNAME
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_auth_helper_can_logout_user(): void
    {
        self::assertSame(0, User::all()->count());
        self::assertFalse(Auth::check());

        AuthHelper::login(new Request(), self::SAMPLE_USERNAME);
        self::assertSame(1, User::all()->count());

        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USERNAME, Auth::user()->username);

        LogoutUser::run();
        self::assertFalse(Auth::check());
    }

    /** @test */
    public function test_auth_helper_can_return_auth_response(): void
    {
        // Not logged in
        self::assertFalse(Auth::check());
        self::assertSame([
            'success' => false,
            'id' => null,
            'playerName' => null
        ], json_decode(AuthHelper::getAuthResponse()->getContent(), true));

        // Logged in
        self::assertSame(0, User::all()->count());

        AuthHelper::login(new Request(), self::SAMPLE_USERNAME);
        self::assertTrue(Auth::check());
        self::assertSame(1, User::all()->count());

        self::assertSame([
            'success' => true,
            'id' => 1,
            'playerName' => self::SAMPLE_USERNAME,
        ], json_decode(AuthHelper::getAuthResponse()->getContent(), true));
    }
}
