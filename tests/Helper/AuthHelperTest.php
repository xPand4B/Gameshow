<?php

namespace Tests\Helper;

use App\Helper\AuthHelper;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthHelperTest extends TestCase
{
    /** @var string  */
    private const SAMPLE_USERNAME = 'xPand';

    /** @test */
    public function test_auth_helper_can_create_and_login_user(): void
    {
        self::assertSame(0, User::all()->count());
        self::assertFalse(Auth::check());

        $response = AuthHelper::login(self::SAMPLE_USERNAME);

        self::assertSame(1, User::all()->count());
        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USERNAME, Auth::user()->username);

        self::assertSame([
            'success' => true,
            'playerName' => self::SAMPLE_USERNAME
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_auth_helper_can_login_existing_user(): void
    {
        self::assertSame(0, User::all()->count());
        self::assertFalse(Auth::check());

        User::create([
            'username' => self::SAMPLE_USERNAME
        ]);
        self::assertSame(1, User::all()->count());

        $response = AuthHelper::login(self::SAMPLE_USERNAME);

        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USERNAME, Auth::user()->username);

        self::assertSame([
            'success' => true,
            'playerName' => self::SAMPLE_USERNAME
        ], json_decode($response->getContent(), true));
    }

    /** @test */
    public function test_auth_helper_can_logout_user(): void
    {
        self::assertSame(0, User::all()->count());
        self::assertFalse(Auth::check());

        AuthHelper::login(self::SAMPLE_USERNAME);
        self::assertSame(1, User::all()->count());

        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USERNAME, Auth::user()->username);

        AuthHelper::logout();
        self::assertFalse(Auth::check());
    }

    /** @test */
    public function test_auth_helper_can_return_auth_response(): void
    {
        // Not logged in
        self::assertFalse(Auth::check());
        self::assertSame([
            'success' => false,
            'playerName' => null
        ], json_decode(AuthHelper::getAuthResponse()->getContent(), true));

        // Logged in
        self::assertSame(0, User::all()->count());

        AuthHelper::login(self::SAMPLE_USERNAME);
        self::assertTrue(Auth::check());
        self::assertSame(1, User::all()->count());

        self::assertSame([
            'success' => true,
            'playerName' => self::SAMPLE_USERNAME
        ], json_decode(AuthHelper::getAuthResponse()->getContent(), true));
    }
}
