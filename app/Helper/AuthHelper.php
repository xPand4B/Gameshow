<?php

namespace App\Helper;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthHelper extends Controller
{
    private const AUTH_TOKEN_NAME = 'auth_token';

    public static function login(Request $request, string $username): JsonResponse
    {
        self::logoutCurrentUser();

        $token = $request->cookie(self::AUTH_TOKEN_NAME);

        $user = User::where([
            ['username',   '=', $username],
            ['auth_token', '=', $token],
        ])->get();

        if ($user->count() === 0) {
            $token = Str::random(24);

            $user = User::create([
                'username'      => $username,
                'auth_token'    => $token,
                'last_login_ip' => $request->getClientIp(),
                'last_login_at' => Carbon::now()->toDateTimeString(),
            ]);
        } else {
            $user = $user[0];

            $user->update([
                'last_login_ip' => $request->getClientIp(),
                'last_login_at' => Carbon::now()->toDateTimeString(),
            ]);
        }

        Auth::login($user);

        return self::getAuthResponse()->withCookie(
          cookie()->forever(self::AUTH_TOKEN_NAME, $token)
        );
    }

    public static function logoutCurrentUser(): void
    {
        if (Auth::check()) {
            Auth::logout();
        }
    }

    public static function getAuthResponse(): JsonResponse
    {
        return response()->json([
            'success' => !!Auth::user(),
            'id' => Auth::user()->id ?? null,
            'playerName' => Auth::user()->username ?? null,
        ]);
    }
}
