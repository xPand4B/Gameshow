<?php

namespace Tests\Actions\Auth;

use App\Actions\Auth\LogoutUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

/**
 * @group Actions
 */
class LogoutUserTest extends TestCase
{
    /** @test */
    public function test_it_can_logout_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        self::assertCount(1, User::all());

        Auth::login($user);
        self::assertTrue(Auth::check());

        LogoutUser::run();
        self::assertFalse(Auth::check());
    }
}
