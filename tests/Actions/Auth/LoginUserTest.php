<?php

namespace Tests\Actions\Auth;

use App\Actions\Auth\LoginUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @group Actions
 */
class LoginUserTest extends TestCase
{
    public const SAMPLE_USER_USERNAME = 'xPand';
    public const SAMPLE_USER_AUTH_TOKEN = 'aaaaabbbbbccccc';

    /** @test */
    public function test_it_can_login_new_user(): void
    {
        self::assertCount(0, User::all());
        LoginUser::run(new Request(), self::SAMPLE_USER_USERNAME, self::SAMPLE_USER_AUTH_TOKEN);

        self::assertCount(1, User::all());
        self::assertTrue(Auth::check());
        self::assertSame(self::SAMPLE_USER_USERNAME, Auth::user()->username);
        self::assertSame(self::SAMPLE_USER_AUTH_TOKEN, Auth::user()->auth_token);
    }

    /** @test */
    public function test_it_can_login_existing_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        LoginUser::run(new Request(), $user->username, $user->auth_token);
        self::assertCount(1, User::all());

        self::assertTrue(Auth::check());
        self::assertSame($user->username, Auth::user()->username);
        self::assertSame($user->auth_token, Auth::user()->auth_token);
    }
}
